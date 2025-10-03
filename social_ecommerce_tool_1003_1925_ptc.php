<?php
// 代码生成时间: 2025-10-03 19:25:46
defined('BASEPATH') OR exit('No direct script access allowed');

class SocialEcommerceTool extends CI_Controller {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Product_model');
        $this->load->library('form_validation');
    }

    /**
     * Index Page for this controller.
     */
    public function index() {
        $this->load->view('welcome_message');
    }

    /**
     * User Registration
     */
    public function register() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('register');
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
            ];

            if ($this->User_model->create_user($data)) {
                $this->session->set_flashdata('message', 'Registration successful!');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Registration failed!');
                $this->load->view('register');
            }
        }
    }

    /**
     * User Login
     */
    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->get_user_by_username($username);

            if ($user && password_verify($password, $user['password'])) {
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('is_logged_in', true);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid credentials!');
                $this->load->view('login');
            }
        }
    }

    /**
     * Dashboard for logged-in users
     */
    public function dashboard() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('login');
        }

        $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('dashboard', $data);
    }

    /**
     * Logout user
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}

/* End of file SocialEcommerceTool.php */
?>