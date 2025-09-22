<?php
// 代码生成时间: 2025-09-23 00:50:02
class AuditLog extends CI_Model
{
    protected $table = 'audit_logs'; // Database table name for audit logs

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

    /**
     * Logs an audit entry to the database.
     *
     * @param string $action Action performed.
     * @param string $user_id ID of the user who performed the action.
     * @param string $description Brief description of the action.
     * @return bool|int Returns the ID of the inserted log entry or FALSE on failure.
     */
    public function log($action, $user_id, $description)
    {
        // Prepare data for the log
        $data = array(
            'action' => $action,
            'user_id' => $user_id,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
        );

        try {
            // Insert the log entry into the database
            return $this->db->insert($this->table, $data);
        } catch (Exception $e) {
            // Log the error to a file or error handling system
            log_message('error', 'Audit log insertion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves audit logs.
     *
     * @param int $limit Number of log entries to retrieve.
     * @param int $offset Offset for pagination.
     * @return array Returns an array of audit log entries.
     */
    public function get_logs($limit = 10, $offset = 0)
    {
        try {
            $query = $this->db->get($this->table, $limit, $offset);
            return $query->result_array();
        } catch (Exception $e) {
            log_message('error', 'Failed to retrieve audit logs: ' . $e->getMessage());
            return array();
        }
    }

    /**
     * Deletes old audit logs.
     *
     * @param int $days Number of days to consider logs old.
     * @return bool Returns TRUE on success or FALSE on failure.
     */
    public function delete_old_logs($days)
    {
        $date_threshold = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        try {
            $this->db->where('created_at <', $date_threshold);
            return $this->db->delete($this->table);
        } catch (Exception $e) {
            log_message('error', 'Failed to delete old audit logs: ' . $e->getMessage());
            return false;
        }
    }
}
