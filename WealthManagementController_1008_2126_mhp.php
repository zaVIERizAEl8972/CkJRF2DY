<?php
// 代码生成时间: 2025-10-08 21:26:48
defined('BASEPATH') OR exit('No direct script access allowed');

// WealthManagementController.php
class WealthManagementController extends CI_Controller {
    // 构造函数
    public function __construct() {
        parent::__construct();
        // 加载数据库库
        $this->load->database();
        // 加载模型
        $this->load->model('WealthManagementModel');
    }

    // 显示财富管理工具的主页面
    public function index() {
        $data['title'] = 'Wealth Management Tool';
        // 加载视图
        $this->load->view('wealth_management/index', $data);
    }

    // 提交财富管理数据
    public function submit() {
        // 检查表单数据
        if ($this->input->post()) {
            try {
                // 获取表单数据
                $wealth_data = $this->input->post();
                // 调用模型方法处理数据
                $result = $this->WealthManagementModel->processWealthData($wealth_data);
                // 检查结果
                if ($result) {
                    // 数据处理成功
                    $this->session->set_flashdata('message', 'Wealth data submitted successfully.');
                } else {
                    // 数据处理失败
                    $this->session->set_flashdata('message', 'Failed to submit wealth data.');
                }
            } catch (Exception $e) {
                // 错误处理
                $this->session->set_flashdata('message', 'Error: ' . $e->getMessage());
            }
        } else {
            // 表单验证失败
            $this->session->set_flashdata('message', 'Invalid form submission.');
        }
        // 重定向到首页
        redirect('wealth_management');
    }
}
