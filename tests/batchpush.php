<?php

/**
 * 后台推送数据
 */

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/config.php';


use Xgold\Helper\GzlHttp;
use Illuminate\Database\Capsule\Manager as Capsule;

// 数据库连接配置
$capsule = new Capsule;
$capsule->addConnection($config['database']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$plqs = $capsule::table($config['point_logs_queue_table_name'])->where('status', 0)->orderBy('created_at')->limit(100)->get();

if ($plqs->count()) {
    $dataString = json_encode($plqs);
    $data = [
        'batch_data' => $dataString,
        'timestamp'  => time(),
        'appid' => $config['appid'],
    ];

    $data['sign'] = GzlHttp::getSign($data, $config['secret_key']);
    $rsData = GzlHttp::post($config['base_uri'] . 'pointlogs/batch', $data);

    if (count($rsData['data'])) {
        $finishedIds = [];
        foreach ($rsData['data'] as $item) {
            $finishedIds[] = $item['id'];
        }
        if ( !empty($finishedIds)) {
            $capsule::table($config['point_logs_queue_table_name'])->whereIn('id', $finishedIds)->update(['status' => 1]);
        }
    }


}
