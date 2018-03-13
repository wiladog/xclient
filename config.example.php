<?php

// 替换成真实的配置
$config = [
    'base_uri' => 'http://api.xgold.infinix.test/v1/', // Xgold API 地址
    'appid' => 1, // Xgold 中的APPID
    // 数据库配置
    'database' => [
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