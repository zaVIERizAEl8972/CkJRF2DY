<?php
// 代码生成时间: 2025-10-03 02:47:21
// application/controllers/DeviceStatusMonitor.php
defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceStatusMonitor extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Load necessary libraries
        $this->load->library('session');
        $this->load->helper('url');
        // Load the model for device status
        $this->load->model('DeviceStatusModel');
    }

    /**
     * Display the list of devices and their statuses
     */
    public function index() {
        try {
            // Retrieve the list of devices
            $devices = $this->DeviceStatusModel->getDevices();
            
            // Check if devices are retrieved successfully
            if ($devices === false) {
                // Handle error scenario
                $this->session->set_flashdata('error', 'Failed to retrieve devices.');
                redirect('error');
            }

            // Pass the devices array to the view
            $data['devices'] = $devices;
            $this->load->view('device_status', $data);
        } catch (Exception $e) {
            // Log the error and redirect to error page
            log_message('error', $e->getMessage());
            redirect('error');
        }
    }
}

// application/models/DeviceStatusModel.php
class DeviceStatusModel extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get the list of devices and their statuses
     *
     * @return array|bool
     */
    public function getDevices() {
        // Query the database to get the devices
        $query = $this->db->get('devices');
        
        // Check if the query was successful
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}

// application/views/device_status.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Device Status Monitor</title>
</head>
<body>
    <h1>Device Status Monitor</h1>
    <table border="1">
        <tr>
            <th>Device ID</th>
            <th>Device Name</th>
            <th>Status</th>
        </tr>
        <?php foreach ($devices as $device): ?>
            <tr>
                <td><?php echo $device['device_id']; ?></td>
                <td><?php echo $device['device_name']; ?></td>
                <td><?php echo $device['status']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>