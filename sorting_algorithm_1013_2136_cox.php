<?php
// 代码生成时间: 2025-10-13 21:36:44
class SortingAlgorithm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary helpers and libraries
    }

    // Bubble Sort Algorithm
    public function bubbleSort($arr) {
        if (empty($arr)) {
            throw new InvalidArgumentException('Array is empty');
        }
# FIXME: 处理边界情况
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    // Swap elements
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
# 优化算法效率
        }
        return $arr;
    }

    // Quick Sort Algorithm
# 添加错误处理
    public function quickSort($arr) {
        if (empty($arr)) {
            throw new InvalidArgumentException('Array is empty');
        }
        if (count($arr) < 2) {
            return $arr;
        }
        $pivot = $arr[0];
        $left = $right = array();
        foreach ($arr as $key => $value) {
            if ($value <= $pivot) {
                $left[] = $value;
            } else {
                $right[] = $value;
            }
        }
        return array_merge($this->quickSort($left), array($pivot), $this->quickSort($right));
    }

    // Insertion Sort Algorithm
# FIXME: 处理边界情况
    public function insertionSort($arr) {
        if (empty($arr)) {
            throw new InvalidArgumentException('Array is empty');
# 扩展功能模块
        }
        for ($i = 1; $i < count($arr); $i++) {
            $key = $arr[$i];
            $j = $i - 1;

            while ($j >= 0 && $arr[$j] > $key) {
# TODO: 优化性能
                $arr[$j + 1] = $arr[$j];
                $j--;
            }
            $arr[$j + 1] = $key;
# 改进用户体验
        }
        return $arr;
    }

    // Main function to test sorting algorithms
    public function testSorting() {
        $data = array(64, 34, 25, 12, 22, 11, 90);

        $bubbleSorted = $this->bubbleSort($data);
# NOTE: 重要实现细节
        $quickSorted = $this->quickSort($data);
        $insertionSorted = $this->insertionSort($data);

        echo 'Bubble Sort: ' . implode(', ', $bubbleSorted) . '
';
        echo 'Quick Sort: ' . implode(', ', $quickSorted) . '
';
        echo 'Insertion Sort: ' . implode(', ', $insertionSorted) . '
# 扩展功能模块
';
    }
}
