<?php
// 代码生成时间: 2025-09-23 22:14:21
class DatabaseMigrationTool {

    protected $ci;
    protected $db;

    /**
     * Constructor
     *
     * Initialize CodeIgniter instance and database
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->db = $this->ci->db;
    }

    /**
     * Run migration
     *
     * @param array $migrations List of migration files to run
     * @return bool
     */
    public function run(array $migrations) {
        try {
            foreach ($migrations as $migration) {
                if (!$this->db->query(file_get_contents($migration))) {
                    // Log error and return false if migration fails
                    log_message('error', 'Migration failed for: ' . basename($migration));
                    return false;
                }
            }
            return true;
        } catch (Exception $e) {
            // Log exception and return false
            log_message('error', 'Migration error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Rollback migration
     *
     * @param array $migrations List of migration files to rollback
     * @return bool
     */
    public function rollback(array $migrations) {
        try {
            foreach ($migrations as $migration) {
                // Assuming migration file contains an array with 'up' and 'down' SQL queries
                $sql = include($migration);
                if (!empty($sql['down']) && !$this->db->query($sql['down'])) {
                    // Log error and return false if rollback fails
                    log_message('error', 'Rollback failed for: ' . basename($migration));
                    return false;
                }
            }
            return true;
        } catch (Exception $e) {
            // Log exception and return false
            log_message('error', 'Rollback error: ' . $e->getMessage());
            return false;
        }
    }
}
