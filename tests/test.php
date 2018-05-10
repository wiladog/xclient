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


for ($i = 1; $i <= 150; $i++) {
    $rs = $xgoldClient->pointlogs($uid, 100, 1, $related);
    var_dump($rs.'-'.$i);
}



//$alterationData = [
//	'id' => 'eb528ad4-5262-11e8-8d64-000c293f0be7',
//    'status' => 2,
//    'related' => time(),
//];
//$rs = $xgoldClient->alteration($alterationData);
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