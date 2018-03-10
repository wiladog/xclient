<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 07/03/2018
 * Time: 3:42 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Xgold\Client;

require_once __DIR__. '/a.php';

echo __DIR__;

$rs = copy(__DIR__. '/a.php',__DIR__.'/b.php');

var_dump($rs);


exit('debug...');


$database = [
    'driver'    => 'mysql',
    'host'      => '192.168.33.10',
    'database'  => 'xgold_infinix_dev',
    'username'  => 'root',
    'password'  => '0.1234',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_bin',
    'prefix'    => '',
];

$config = [
    'base_uri' => 'http://api.xgold.infinix.test/index.php/v1/',
    'database' => $database,
];
$client = new Client($config);

// 获取用户的XGOLD
$memberXgold = $client->pointlogs(58,51,200,1,'23434111');
var_dump($memberXgold);


//
//$plqs = $capsule::table('point_logs_queue')->limit(100)->get();
//$tmp = '';
//foreach ($plqs as $plq) {
//    $tmp .= $plq->uid.'-'.$plq->appid.'-'.$plq->point.'-'.$plq->type.'-'.$plq->related.',';
//}
//$tmp = substr($tmp, 0, -1);
//
//$tmpData = [
//    'batch_data' => $tmp,
//    'timestamp' => time(),
//];
//$tmpData['sign'] = GzlHttp::getSign($tmpData);
//
//$rsData = GzlHttp::post($this->getConfig('pointlogs_batch'), $tmpData);
//
//var_dump($rsData);


//             $users = Capsule::table('point_logs_queue')->limit(100)->get();
//             var_dump($users);
//            unset()
//            $cur_time = time();
//            $data['created_at'] = $cur_time;
//            $data['updated_at'] = $cur_time;
//            Capsule::table('point_logs_queue')->insert([$data]);
//            Capsule::table('point_logs_queue')->insert([$data]);
//            Capsule::table('point_logs_queue')->insert([$data]);

//            Capsule::schema()->dropIfExists('point_logs_queue');
//
//            Capsule::schema()->create('point_logs_queue', function($table)
//            {
//                $table->increments('id');
//                $table->integer('uid');
//                $table->integer('appid');
//                $table->integer('point');
//                $table->tinyInteger('type');
//                $table->string('related');
//                $table->integer('created_at');
//                $table->integer('updated_at');
//
//            });