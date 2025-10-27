<?php
// 代码生成时间: 2025-10-28 06:22:11
class WealthManagementController extends CI_Controller {

    /**
     * Constructor for the controller.
     */
    public function __construct() {
        parent::__construct();
        // Load the necessary libraries and models
        $this->load->library('form_validation');
        $this->load->model('WealthManagementModel');
    }

    /**
     * Displays the wealth management dashboard.
     */
    public function index() {
        // Check if the user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Get the data required for the dashboard
        $data['transactions'] = $this->WealthManagementModel->get_transactions();
        $data['investments'] = $this->WealthManagementModel->get_investments();

        // Load the dashboard view
        $this->load->view('wealth_management_dashboard', $data);
    }

    /**
     * Handles the transaction form submission.
     */
    public function add_transaction() {
        // Check if the user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Validate the form input
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
        $this->form_validation->set_rules('type', 'Type', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Form validation failed
            $this->session->set_flashdata('error', 'Please check the form and try again.');
            redirect('wealth_management');
        } else {
            // Form validation passed
            $amount = $this->input->post('amount');
            $type = $this->input->post('type');
            
            // Add the transaction to the database
            if ($this->WealthManagementModel->add_transaction($amount, $type)) {
                $this->session->set_flashdata('success', 'Transaction added successfully.');
                redirect('wealth_management');
            } else {
                // Handle transaction addition error
                $this->session->set_flashdata('error', 'Failed to add transaction. Please try again later.');
                redirect('wealth_management');
            }
        }
    }

    /**
     * Handles the investment form submission.
     */
    public function add_investment() {
        // Check if the user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Validate the form input
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
        $this->form_validation->set_rules('return_rate', 'Return Rate', 'required|numeric');
        $this->form_validation->set_rules('duration', 'Duration', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            // Form validation failed
            $this->session->set_flashdata('error', 'Please check the form and try again.');
            redirect('wealth_management');
        } else {
            // Form validation passed
            $amount = $this->input->post('amount');
            $return_rate = $this->input->post('return_rate');
            $duration = $this->input->post('duration');
            
            // Add the investment to the database
            if ($this->WealthManagementModel->add_investment($amount, $return_rate, $duration)) {
                $this->session->set_flashdata('success', 'Investment added successfully.');
                redirect('wealth_management');
            } else {
                // Handle investment addition error
                $this->session->set_flashdata('error', 'Failed to add investment. Please try again later.');
                redirect('wealth_management');
            }
        }
    }
}
