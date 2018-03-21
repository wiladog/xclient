<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 07/03/2018
 * Time: 3:42 PM
 */

// 使用示例
require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/config.php';

use Xgold\Client;

// xclient 使用
$xgoldClient = new Client($config);

$uids = [825191, 2345189];
$uid = $uids[rand(0, 1)];
$related = time();
//$related = '';
//$uid = 2345189;
// 积分变更
//$rs = $xgoldClient->pointlogs($uid, $config['appid'], 200, 1, $related);

// 测试检测回调
$data = [
    'id'      => '0bc7ad78-2cd2-11e8-9449-acde48001122',
    'uid'     => 2345189,
    'point'   => 200,
    'type'  => 1,
];
$rs = $xgoldClient->checkCallback($data);

// 查询积分记录
//$tid = 180; // 交易ID
//$rs = $xgoldClient->getPointlogsDetail($tid);

// 获取用户积分
//$rs = $xgoldClient->getMemberXgold($uid);

// 批量查询积分 返回一个数组
//$uids = '825191-2345189';
//$rs = $xgoldClient->getBatchMemberXgold($uids);

var_dump($rs);
// 回调 传入