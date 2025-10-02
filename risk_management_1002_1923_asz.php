<?php
// 代码生成时间: 2025-10-02 19:23:57
class Risk_management extends CI_Controller {

    /**
     * Constructor
     *
     * Initialize the CodeIgniter and load the necessary models and libraries.
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('risk_model'); // Load the risk model
    }

    /**
     * Index page for the risk management system
     */
    public function index() {
        $data['risks'] = $this->risk_model->get_all_risks(); // Retrieve all risks from the model
        $this->load->view('risk_management_view', $data); // Load the view with risks
    }

    /**
     * Add a new risk to the system
     */
    public function add_risk() {
        $this->load->library('form_validation');
        
        // Define form validation rules
        $this->form_validation->set_rules('risk_name', 'Risk Name', 'required|trim');
        $this->form_validation->set_rules('risk_description', 'Description', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            $this->load->view('add_risk_view');
        } else {
            // Validation passed, save the risk
            $risk_data = array(
                'risk_name' => $this->input->post('risk_name'),
                'risk_description' => $this->input->post('risk_description')
            );
            
            if ($this->risk_model->add_risk($risk_data)) {
                // Success
                redirect('risk_management');
            } else {
                // Error handling
                $this->session->set_flashdata('error', 'Failed to add risk.');
                redirect('risk_management/add_risk');
            }
        }
    }

    /**
     * Edit an existing risk
     */
    public function edit_risk($id) {
        $data['risk'] = $this->risk_model->get_risk($id); // Retrieve the risk by ID
        
        if (empty($data['risk'])) {
            // Risk not found
            show_404();
        }
        
        $this->load->library('form_validation');
        
        // Define form validation rules
        $this->form_validation->set_rules('risk_name', 'Risk Name', 'required|trim');
        $this->form_validation->set_rules('risk_description', 'Description', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            // Validation failed
            $this->load->view('edit_risk_view', $data);
        } else {
            // Validation passed, update the risk
            $risk_data = array(
                'risk_name' => $this->input->post('risk_name'),
                'risk_description' => $this->input->post('risk_description')
            );
            
            if ($this->risk_model->update_risk($id, $risk_data)) {
                // Success
                redirect('risk_management');
            } else {
                // Error handling
                $this->session->set_flashdata('error', 'Failed to update risk.');
                redirect('risk_management/edit_risk/' . $id);
            }
        }
    }

    /**
     * Delete a risk from the system
     */
    public function delete_risk($id) {
        if ($this->risk_model->delete_risk($id)) {
            // Success
            redirect('risk_management');
        } else {
            // Error handling
            $this->session->set_flashdata('error', 'Failed to delete risk.');
            redirect('risk_management');
        }
    }
}

/**
 * Risk Model
 *
 * Handles the data operations for the risk management system
 */
class Risk_model extends CI_Model {

    /**
     * Retrieve all risks
     */
    public function get_all_risks() {
        return $this->db->get('risks')->result();
    }

    /**
     * Add a new risk
     */
    public function add_risk($data) {
        return $this->db->insert('risks', $data);
    }

    /**
     * Retrieve a risk by ID
     */
    public function get_risk($id) {
        $this->db->where('id', $id);
        return $this->db->get('risks')->row();
    }

    /**
     * Update a risk
     */
    public function update_risk($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('risks', $data);
    }

    /**
     * Delete a risk
     */
    public function delete_risk($id) {
        $this->db->where('id', $id);
        return $this->db->delete('risks');
    }
}
