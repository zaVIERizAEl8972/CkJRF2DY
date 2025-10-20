<?php
// 代码生成时间: 2025-10-21 00:34:18
defined('BASEPATH') OR exit('No direct script access allowed');

class DnsResolver extends CI_Controller {

    /**
     * DNS解析和缓存工具
     *
     * @param string $domain 域名
     * @return void
     */
    public function index($domain = '') {
        // 检查域名是否已提供
        if (empty($domain)) {
            $this->output->set_status_header(400);
            echo json_encode(['error' => 'Domain is required.']);
            return;
        }

        // 缓存解析结果的键名
        $cacheKey = 'dns_cache_' . $domain;

        // 尝试从缓存获取解析结果
        $dnsResult = $this->cache->get($cacheKey);
        if ($dnsResult !== false) {
            echo json_encode(['ip' => $dnsResult['ip'], 'timestamp' => $dnsResult['timestamp']]);
            return;
        }

        // 执行DNS解析
        $ip = gethostbyname($domain);
        if ($ip === $domain) {
            $this->output->set_status_header(500);
            echo json_encode(['error' => 'DNS resolution failed.']);
            return;
        }

        // 将解析结果存入缓存
        $dnsResult = [
            'ip' => $ip,
            'timestamp' => date('Y-m-d H:i:s'),
        ];
        $this->cache->save($cacheKey, $dnsResult, 3600); // 缓存1小时

        // 返回解析结果
        echo json_encode($dnsResult);
    }

    /**
     * 初始化缓存
     *
     * @return void
     */
    private function initializeCache() {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    }
}
