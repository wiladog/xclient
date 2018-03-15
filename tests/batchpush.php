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

$plqs = $capsule::table('point_logs_queue')->where('status', 0)->orderBy('created_at')->limit(100)->get();

// exit('debug....');
if ($plqs->count()) {
    $dataString = '';
    $ids = [];
    foreach ($plqs as $plq) {
        $ids[] = $plq->id;
        $dataString .= $plq->uid . '-' . $plq->appid . '-' . $plq->point . '-' . $plq->type . '-' . $plq->related . '-' . $plq->id . ',';
    }
    $dataString = substr($dataString, 0, -1);
    $data = [
        'batch_data' => $dataString,
        'timestamp'  => time(),
    ];

    $data['sign'] = GzlHttp::getSign($data);
    $rsData = GzlHttp::post($config['base_uri'] . 'pointlogs/batch', $data);

    $finishedIds = [];
    foreach ($rsData['data'] as $item) {
        $finishedIds[] = $item['id'];
    }
    if(!empty($finishedIds)) {
        $capsule::table('point_logs_queue')->whereIn('id', $finishedIds)->update(['status' => 1]);
    }

}
