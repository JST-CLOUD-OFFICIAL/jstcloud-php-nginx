<?php

// 引入数据库操作文件
require_once 'db.php';

// 处理请求
$path = $_SERVER['PATH_INFO'];

switch ($path) {

    case "":
    case "/":
        $response = array(
            'code' => '200',
            'message' => 'Welcome to Jst AppEngine, Hello World!'
        ); 
        break;

    case '/counter':
        // 获取计数器值
        $value = get_counter_value($db);

        // 构建响应数组
        $response = array(
            'status' => 'success',
            'value' => $value
        );

        break;

    case '/counter/increment':
        try {
            // 获取当前计数器值并加1
            $value = get_counter_value($db);
            if ($value === null) {
                // 如果计数器不存在，则插入一条默认记录
                set_counter_value($db, 0);
                $value = 0;
            } else {
                $value += 1;
            }
    
            // 更新计数器值
            set_counter_value($db, $value);
    
            // 构建响应数组
            $response = array(
                'status' => 'success',
                'message' => "计数器的新值为$value"
            );
    
        } catch (PDOException $e) {
            // 处理数据库错误
            $response = array(
                'status' => 'error',
                'message' => '数据库错误'
            );
        }
        break;
    
    case '/counter/decrement':
        try {
            // 获取当前计数器值并减1
            $value = get_counter_value($db);
            if ($value === null) {
                // 如果计数器不存在，则插入一条默认记录
                set_counter_value($db, 0);
                $value = 0;
            } else {
                $value -= 1;
            }
    
            // 更新计数器值
            set_counter_value($db, $value);
    
            // 构建响应数组
            $response = array(
                'status' => 'success',
                'message' => "计数器的新值为$value"
            );
    
        } catch (PDOException $e) {
            // 处理数据库错误
            $response = array(
                'status' => 'error',
                'message' => '数据库错误'
            );
        }
        break;

    default:
        // 处理未知请求
        $response = array(
            'status' => 'error',
            'message' => '未知请求'
        );
}

// 设置响应头
header('Content-Type: application/json');

// 将响应编码为JSON格式
$json = json_encode($response);

// 输出响应内容
echo $json;