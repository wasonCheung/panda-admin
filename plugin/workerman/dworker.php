<?php

use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Worker;

require_once __DIR__ . '/../vendor/autoload.php';
$worker = new Worker('http://0.0.0.0:8080');

// 单应用多模块->模块高内聚之间低耦合
// 开发原则，原则上兼容thinkphp生态->workerman特性

// worker启动
// 配置加载->环境配置->系统配置->合并
// 容器
// 配置加载
// 多语言加载
//

$worker->onMessage = function (TcpConnection $connection, Request $request) {
    // 请求进入
    // 全局前置拦截器
    // 请求模块解析
    // 模块前置拦截器
    // 控制器解析
    // 控制器前置拦截器
    // 控制器处理
    // 内容输出
    // 控制器后置拦截器
    // 模块后置拦截器
    // 全局后置拦截器
    $connection->send("hello");
};
// 运行worker
Worker::runAll();
