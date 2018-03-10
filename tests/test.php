<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 07/03/2018
 * Time: 3:42 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Xgold\Client;

// 获取用户的XGOLD
$memberXgold = Client::pointlogs(58,51,200,1,'23434111');
var_dump($memberXgold);



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