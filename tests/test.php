<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 07/03/2018
 * Time: 3:42 PM
 */

// 使用示例
require_once __DIR__ .'/../vendor/autoload.php';
require __DIR__ .'/config.php';

use Xgold\Client;
use Illuminate\Database\Capsule\Manager as Capsule;


// xclient 使用
$xgoldClient = new Client($config);
$uid = 825191;
// 积分变更
$rs = $xgoldClient->pointlogs($uid, $config['appid'], 200, 1, '23434111');
var_dump($rs);
//
//// 查询积分记录
//$tid = 180; // 交易ID
//$rs = $xgoldClient->getPointlogsDetail($tid);
//var_dump($rs);
//
//// 获取用户积分
//$rs = $xgoldClient->getMemberXgold($uid);
//var_dump($rs);
