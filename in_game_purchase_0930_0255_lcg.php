<?php
// 代码生成时间: 2025-09-30 02:55:25
defined('BASEPATH') OR exit('No direct script access allowed');

// 引入CodeIgniter核心类库
require_once APPPATH . 'core/Controller.php';

class InGamePurchase extends CI_Controller {

    /**
     * 构造方法
     *
     * 初始化InGamePurchase对象
     */
    public function __construct() {
        parent::__construct();
        // 加载数据库库
        $this->load->database();
        // 加载model
        $this->load->model('purchase_model');
    }

    /**
     * 处理游戏内购请求
     *
     * @param int $productId 产品ID
     * @param int $userId 用户ID
     * @return void
     */
    public function purchase($productId, $userId) {
        try {
            // 验证产品ID和用户ID是否有效
            if (!is_numeric($productId) || !is_numeric($userId)) {
                $this->response(['error' => 'Invalid product or user ID'], 400);
                return;
            }

            // 从数据库中获取产品信息
            $product = $this->purchase_model->getProductById($productId);
            if (!$product) {
                $this->response(['error' => 'Product not found'], 404);
                return;
            }

            // 检查用户是否已购买该产品
            if ($this->purchase_model->hasPurchased($userId, $productId)) {
                $this->response(['error' => 'User has already purchased this product'], 409);
                return;
            }

            // 执行购买逻辑
            if ($this->purchase_model->completePurchase($userId, $productId)) {
                $this->response(['success' => 'Purchase completed successfully'], 200);
            } else {
                $this->response(['error' => 'Purchase failed'], 500);
            }

        } catch (Exception $e) {
            // 处理异常
            $this->response(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * 设置响应头部并返回数据
     *
     * @param array $data 要返回的数据
     * @param int $httpStatusCode HTTP状态码
     * @return void
     */
    private function response($data, $httpStatusCode) {
        header('Content-Type: application/json; charset=utf-8');
        header('HTTP/1.1 ' . $httpStatusCode . ' ' . $this->getHttpStatusMessage($httpStatusCode));
        echo json_encode($data);
    }

    /**
     * 获取HTTP状态码对应的描述
     *
     * @param int $httpStatusCode HTTP状态码
     * @return string
     */
    private function getHttpStatusMessage($httpStatusCode) {
        // 定义HTTP状态码和对应的描述
        $statusCodes = [
            200 => 'OK',
            400 => 'Bad Request',
            404 => 'Not Found',
            409 => 'Conflict',
            500 => 'Internal Server Error'
        ];

        return isset($statusCodes[$httpStatusCode]) ? $statusCodes[$httpStatusCode] : 'Unknown Status';
    }
}

/* End of file in_game_purchase.php */
/* Location: ./application/controllers/in_game_purchase.php */