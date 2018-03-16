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

// xclient 使用
$xgoldClient = new Client($config);

$uids = [825191,2345189];
$uid = $uids[rand(0,1)];


//$uid = 2345189;
// 积分变更
//$rs = $xgoldClient->pointlogs($uid, $config['appid'], 200, 1, time());
//var_dump($rs);

// 查询积分记录
//$tid = 180; // 交易ID
//$rs = $xgoldClient->getPointlogsDetail($tid);

// 获取用户积分
//$rs = $xgoldClient->getMemberXgold($uid);

// 批量查询积分 返回一个数组
//$uids = '825191-2345189';
//$rs = $xgoldClient->getBatchMemberXgold($uids);




//var_dump($rs);

// 回调 传入

