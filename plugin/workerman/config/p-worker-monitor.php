<?php

return [
    // 是否开启
    'status' => true,
    // 文件监控检测时间间隔（秒）
    'interval' => 1,
    // 是否开启PHP文件更改监控（调试模式下自动开启）
    'monitor' => env('APP_DEBUG', true),
    // 监控目录排除
    'dirs' => [
        'vendor',
        'runtime',
        'public',
    ],
    // 文件类型
    'types' => [
        'php'
    ],
    'options' => [
        'name' => 'panda-monitor',
        'count' => 1,
    ]
];
