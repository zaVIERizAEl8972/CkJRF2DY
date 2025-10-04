<?php
// 代码生成时间: 2025-10-05 00:00:32
defined('BASEPATH') OR exit('No direct script access allowed');

class DnsCacheTool extends CI_Controller {

    /**
     * 构造函数
     */
    public function __construct() {
        parent::__construct();
        // 加载数据库库
        $this->load->database();
    }

    /**
     * 解析给定域名
     *
     * @param string $domain 域名
     * @return void
     */
    public function resolve($domain) {
        try {
            // 检查是否已经缓存
            $cachedResult = $this->_checkCache($domain);
            if ($cachedResult) {
                // 返回缓存结果
                echo json_encode(['status' => 200, 'result' => $cachedResult]);
                return;
            }

            // 执行DNS解析
            $ip = $this->_getIpAddress($domain);
            if ($ip) {
                // 缓存结果
                $this->_cacheResult($domain, $ip);
                echo json_encode(['status' => 200, 'result' => $ip]);
            } else {
                // 处理解析错误
                echo json_encode(['status' => 500, 'error' => 'Failed to resolve domain']);
            }
        } catch (Exception $e) {
            // 错误处理
            echo json_encode(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    /**
     * 检查缓存
     *
     * @param string $domain 域名
     * @return string|null 缓存的IP地址或null
     */
    private function _checkCache($domain) {
        $query = $this->db->get_where('dns_cache', ['domain' => $domain]);
        if ($query->num_rows() > 0) {
            $result = $query->row();
            // 检查缓存是否过期
            if (time() - strtotime($result->created_at) < 3600) {
                return $result->ip_address;
            }
        }
        return null;
    }

    /**
     * 获取IP地址
     *
     * @param string $domain 域名
     * @return string|bool IP地址或false
     */
    private function _getIpAddress($domain) {
        // 使用gethostbyname()执行DNS解析
        return gethostbyname($domain);
    }

    /**
     * 缓存结果
     *
     * @param string $domain 域名
     * @param string $ip IP地址
     * @return void
     */
    private function _cacheResult($domain, $ip) {
        $data = [
            'domain' => $domain,
            'ip_address' => $ip,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('dns_cache', $data);
    }
}
