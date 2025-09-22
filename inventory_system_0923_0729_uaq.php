<?php
// 代码生成时间: 2025-09-23 07:29:25
class Inventory extends CI_Controller {

    /**
     * Constructor
     *
     * Load the necessary database and helper libraries.
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Inventory_model');
    }

    /**
     * Display the inventory dashboard
     */
    public function index() {
        $data['title'] = 'Inventory Dashboard';
        $data['inventories'] = $this->Inventory_model->get_all_inventories();
        $this->load->view('inventory_dashboard', $data);
    }

    /**
     * Add a new inventory item
     */
    public function add() {
        $this->load->library('form_validation');
        
        $config = array(
            // Define the form validation rules
            array(
                'field' => 'item_name',
                'label' => 'Item Name',
                'rules' => 'required'
            ),
            // Add more fields as needed
        );
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('add_inventory_form');
        } else {
            $this->Inventory_model->add_inventory();
            redirect('inventory/index');
        }
    }

    /**
     * Edit an existing inventory item
     */
    public function edit($id) {
        $data['inventory'] = $this->Inventory_model->get_inventory_by_id($id);
        $this->load->view('edit_inventory_form', $data);
    }

    /**
     * Update an existing inventory item
     */
    public function update($id) {
        $this->Inventory_model->update_inventory($id);
        redirect('inventory/index');
    }

    /**
     * Delete an existing inventory item
     */
    public function delete($id) {
        $this->Inventory_model->delete_inventory($id);
        redirect('inventory/index');
    }
}

/* End of file Inventory.php */
/* Location: ./application/controllers/Inventory.php */