<?php

return [
    // 全局配置
    'global' => [
        'stdoutFile' => runtime_path() . 'worker-std.log',
        'pidFile' => runtime_path() . 'worker-pid.log',
        'logFile' => runtime_path() . 'worker-log.log',
    ],
    'http' => [
        // 自动多应用
        'auto' => [
            'port' => 8080,
            'host' => '127.0.0.1',
            'options' => [
                'name' => 'panda-auto',
                'count' => 12,
            ]
        ],
        // 自动多应用
        'admin' => [
            'port' => 8080,
            'host' => '127.0.0.1',
            'options' => [
                'name' => 'panda-admin',
                'count' => 12,
            ]
        ],
    ],
    'monitor' => [
        // 是否开启
        'status' => true,
        // 文件监控检测时间间隔（秒）
        'interval' => 1,
        // 监控目录排除
        'dirs' => [
            'app',
            'config',
            'plugin',
            'extend',
            'database',
            'vendor',
        ],
        // 文件类型
        'types' => [
            'php'
        ],
        'options' => [
            'name' => 'panda-monitor',
            'count' => 1,
        ]
    ]
];
