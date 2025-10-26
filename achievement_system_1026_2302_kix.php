<?php
// 代码生成时间: 2025-10-26 23:02:15
class Achievement_system {

    protected $CI;
    protected $db;
    protected $user_id;

    /**
     * Constructor
     *
     * Initialize the CI instance and load the database library.
     */
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->db = $this->CI->db;
    }

    /**
     * Set User ID
     *
     * Set the user ID for which achievement data will be managed.
     *
     * @param int $user_id The user ID
     */
    public function set_user_id($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * Get Achievements
     *
     * Retrieve all achievements for the current user.
     *
     * @return array An array of achievements
     */
    public function get_achievements() {
        $query = $this->db->get_where('achievements', array('user_id' => $this->user_id));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    /**
     * Add Achievement
     *
     * Add a new achievement for the current user.
     *
     * @param int $achievement_id The achievement ID
     * @return bool True on success, False on failure
     */
    public function add_achievement($achievement_id) {
        $data = array(
            'user_id' => $this->user_id,
            'achievement_id' => $achievement_id,
            'date_earned' => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('user_achievements', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Remove Achievement
     *
     * Remove an achievement from the current user.
     *
     * @param int $achievement_id The achievement ID
     * @return bool True on success, False on failure
     */
    public function remove_achievement($achievement_id) {
        $this->db->where(array('user_id' => $this->user_id, 'achievement_id' => $achievement_id));

        if ($this->db->delete('user_achievements')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check Achievement
     *
     * Check if the current user has earned a specific achievement.
     *
     * @param int $achievement_id The achievement ID
     * @return bool True if earned, False otherwise
     */
    public function check_achievement($achievement_id) {
        $query = $this->db->get_where('user_achievements', array(
            'user_id' => $this->user_id,
            'achievement_id' => $achievement_id
        ));

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
