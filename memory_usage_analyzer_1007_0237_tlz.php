<?php
// 代码生成时间: 2025-10-07 02:37:23
class MemoryUsageAnalyzer extends CI_Controller {

    private $memoryLimit;
    private $memoryUsage;
    private $peakMemoryUsage;
    private $startMemoryUsage;
    private $startPeakMemoryUsage;

    public function __construct() {
        parent::__construct();
        $this->load->helper('memory_usage');
        $this->memoryLimit = ini_get('memory_limit');
        $this->memoryUsage = memory_get_usage();
        $this->peakMemoryUsage = memory_get_peak_usage();
        $this->startMemoryUsage = $this->memoryUsage;
        $this->startPeakMemoryUsage = $this->peakMemoryUsage;
    }

    /**
     * Get current memory usage
     *
     * @return string Current memory usage in a human-readable format
     */
    public function getCurrentMemoryUsage() {
        $currentMemoryUsage = memory_get_usage();
        return self::formatMemory($currentMemoryUsage);
    }

    /**
     * Get peak memory usage
     *
     * @return string Peak memory usage in a human-readable format
     */
    public function getPeakMemoryUsage() {
        $peakMemoryUsage = memory_get_peak_usage();
        return self::formatMemory($peakMemoryUsage);
    }

    /**
     * Get memory usage since the start of the request
     *
     * @return string Memory usage since the start of the request in a human-readable format
     */
    public function getMemoryUsageSinceStart() {
        $currentMemoryUsage = memory_get_usage();
        $memoryUsageSinceStart = $currentMemoryUsage - $this->startMemoryUsage;
        return self::formatMemory($memoryUsageSinceStart);
    }

    /**
     * Get peak memory usage since the start of the request
     *
     * @return string Peak memory usage since the start of the request in a human-readable format
     */
    public function getPeakMemoryUsageSinceStart() {
        $peakMemoryUsage = memory_get_peak_usage();
        $peakMemoryUsageSinceStart = $peakMemoryUsage - $this->startPeakMemoryUsage;
        return self::formatMemory($peakMemoryUsageSinceStart);
    }

    /**
     * Format memory usage to a human-readable format
     *
     * @param int $bytes Memory usage in bytes
     * @return string Memory usage in a human-readable format
     */
    private function formatMemory($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = pow(1024, $pow);
        $bytes /= $pow;
        return round($bytes, 2) . ' ' . $units[$pow - 1024];
    }
}
