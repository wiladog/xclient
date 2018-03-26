<?php

// 替换成真实的配置
$config = [
    // Xgold API 地址
    'base_uri'                    => 'http://api.xgold.infinix.test/v1/',
    // Xgold 中的APPID
    'appid'                       => 1,
    // Xgold 中的通信密钥
    'secret_key'                  => 'yidingyaobaomi',
    // 本地积分队列表名称
    'point_logs_queue_table_name' => 'point_logs_queue',
    // 数据库配置
    'database'                    => [
        'driver'    => 'mysql',
        'host'      => '192.168.33.10',
        'database'  => 'xgold_infinix_dev',
        'username'  => 'root',
        'password'  => '0.1234',
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_bin',
        'prefix'    => '',
    ],
];