<?php
// 代码生成时间: 2025-10-13 01:36:23
class DataSharding {

    /**
     * 数据库配置数组
     *
     * @var array
     */
    private $dbConfig = [];

    /**
     * 数据库连接实例
     *
     * @var CI_DB_active_record
     */
    private $db;

    /**
     * 构造函数
     *
     * 初始化数据库配置和连接
     *
     * @param array $config 数据库配置数组
     */
    public function __construct($config) {
        $this->dbConfig = $config;
        $this->db = $this->initializeDb($config);
    }

    /**
     * 初始化数据库连接
     *
     * @param array $config 数据库配置数组
     * @return CI_DB_active_record 数据库连接实例
     */
    private function initializeDb($config) {
        $this->db = new CI_DB_active_record();
        $this->db->initialize($config);
        return $this->db;
    }

    /**
     * 分配数据到指定的数据库
     *
     * @param string $data 数据
     * @param int $shardId 分片ID
     * @return bool 分配成功与否
     */
    public function allocateData($data, $shardId) {
        try {
            // 根据分片ID选择数据库配置
            $dbConfig = $this->dbConfig[$shardId] ?? null;
            if (!$dbConfig) {
                throw new Exception("Invalid shard ID: {$shardId}");
            }

            // 重新初始化数据库连接
            $this->initializeDb($dbConfig);

            // 执行数据插入操作
            $this->db->insert('your_table_name', ['data' => $data]);

            return true;
        } catch (Exception $e) {
            // 错误处理
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * 获取所有分片的数据库连接
     *
     * @return array 分片数据库连接数组
     */
    public function getShardDbs() {
        $shardDbs = [];
        foreach ($this->dbConfig as $shardId => $config) {
            $db = $this->initializeDb($config);
            $shardDbs[$shardId] = $db;
        }
        return $shardDbs;
    }
}
