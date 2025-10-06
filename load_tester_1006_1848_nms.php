<?php
// 代码生成时间: 2025-10-06 18:48:38
class LoadTester extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary libraries and helpers
        $this->load->library('curl');
        $this->load->helper('url');
    }

    /**
     * Index method to start the load test
     *
     * @param string $url The URL to test
     * @param int $users The number of simulated users
     * @param int $duration The duration of the test in seconds
     */
    public function index($url, $users, $duration) {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            // Handle invalid URL
            $this->output->set_status_header(400);
            echo json_encode(array(
                'error' => 'Invalid URL provided.'
            ));
            return;
        }

        if (!is_numeric($users) || $users <= 0) {
            // Handle invalid number of users
            $this->output->set_status_header(400);
            echo json_encode(array(
                'error' => 'Invalid number of users.'
            ));
            return;
        }

        if (!is_numeric($duration) || $duration <= 0) {
            // Handle invalid duration
            $this->output->set_status_header(400);
            echo json_encode(array(
                'error' => 'Invalid duration.'
            ));
            return;
        }

        // Start the load test
        $result = $this->performLoadTest($url, $users, $duration);

        // Output the result
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    /**
     * Perform the load test
     *
     * @param string $url The URL to test
     * @param int $users The number of simulated users
     * @param int $duration The duration of the test in seconds
     * @return array The result of the load test
     */
    private function performLoadTest($url, $users, $duration) {
        $startTime = time();
        $endTime = $startTime + $duration;
        $requests = 0;

        while (time() < $endTime) {
            for ($i = 0; $i < $users; $i++) {
                // Simulate user requests using cURL
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_exec($ch);
                $requests++;
            }
        }

        // Calculate the total requests per second
        $requestsPerSecond = $requests / $duration;

        return array(
            'total_requests' => $requests,
            'requests_per_second' => $requestsPerSecond,
            'average_response_time' => $this->calculateAverageResponseTime($url, $users, $duration),
        );
    }

    /**
     * Calculate the average response time
     *
     * @param string $url The URL to test
     * @param int $users The number of simulated users
     * @param int $duration The duration of the test in seconds
     * @return float The average response time in seconds
     */
    private function calculateAverageResponseTime($url, $users, $duration) {
        $totalTime = 0;
        $requests = 0;

        for ($i = 0; $i < $users; $i++) {
            $startTime = microtime(true);
            curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_exec($ch);
            $endTime = microtime(true);
            $totalTime += ($endTime - $startTime);
            $requests++;
        }

        return $requests > 0 ? $totalTime / $requests : 0;
    }
}
