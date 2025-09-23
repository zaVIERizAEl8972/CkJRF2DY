<?php
// 代码生成时间: 2025-09-24 00:54:46
class HashCalculator extends CI_Controller {

    /**
     * Index Method for this Controller.
     */
    public function index() {
        $this->load->view('hash_calculator_view');
    }

    /**
     * Calculate Hash
     * 
     * @param string $algorithm Hashing algorithm
     * @param string $data Data to hash
     * @return string Hashed data
     */
    public function calculate_hash($algorithm = 'sha256', $data = '') {
        // Check if data is provided
        if (empty($data)) {
            $this->output->set_status_header(400);
            return $this->output->set_output(json_encode(array('error' => 'No data provided.')));
        }

        // Check if algorithm is supported
        $supported_algorithms = hash_algos();
        if (!in_array($algorithm, $supported_algorithms)) {
            $this->output->set_status_header(400);
            return $this->output->set_output(json_encode(array('error' => 'Unsupported algorithm.')));
        }

        // Calculate hash
        $hash = hash($algorithm, $data);
        return json_encode(array('hash' => $hash));
    }
}

/**
 * Hash Calculator View
 * 
 * @package CodeIgniter
 * @subpackage Views
 * @author Your Name
 * @version 1.0
 */
$this->load->view('hash_calculator_view', array(
    'page_title' => 'Hash Calculator',
    'algorithms' => hash_algos()
));

?>