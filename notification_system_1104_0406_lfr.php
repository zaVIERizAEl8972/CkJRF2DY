<?php
// 代码生成时间: 2025-11-04 04:06:23
// notification_system.php
// 这是一个基于CodeIgniter框架的通知提示系统

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    // 构造函数
    public function __construct() {
        parent::__construct();
        // 加载模型、库等
    }

    // 显示通知
    public function index() {
        try {
            // 检查是否有通知
            $notifications = $this->notification_model->get_notifications();
            
            // 检查是否有通知数据
            if (empty($notifications)) {
                $this->session->set_flashdata('message', 'No notifications found.');
                redirect('dashboard');
            }
            
            // 加载视图并传递通知数据
            $data['notifications'] = $notifications;
            $this->load->view('notifications/index', $data);
        } catch (Exception $e) {
            // 错误处理
            log_message('error', 'Error in Notification index: ' . $e->getMessage());
            $this->session->set_flashdata('message', 'Error occurred while fetching notifications.');
            redirect('dashboard');
        }
    }

    // 标记通知为已读
    public function mark_as_read($id) {
        try {
            // 检查通知ID是否存在
            if (!$this->notification_model->exists($id)) {
                $this->session->set_flashdata('message', 'Notification not found.');
                redirect('notifications');
            }

            // 标记通知为已读
            $this->notification_model->mark_as_read($id);
            $this->session->set_flashdata('message', 'Notification marked as read.');
            redirect('notifications');
        } catch (Exception $e) {
            // 错误处理
            log_message('error', 'Error in Notification mark_as_read: ' . $e->getMessage());
            $this->session->set_flashdata('message', 'Error occurred while marking notification as read.');
            redirect('notifications');
        }
    }

}

// 通知模型
class Notification_model extends CI_Model {

    // 获取所有通知
    public function get_notifications() {
        $query = $this->db->get('notifications');
        return $query->result();
    }

    // 检查通知是否存在
    public function exists($id) {
        $query = $this->db->where('id', $id)->get('notifications');
        return $query->num_rows() > 0;
    }

    // 标记通知为已读
    public function mark_as_read($id) {
        $this->db->set('is_read', 1);
        $this->db->where('id', $id);
        $this->db->update('notifications');
    }

}
