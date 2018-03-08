<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 07/03/2018
 * Time: 3:42 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Xgold\Member;

// 获取用户的XGOLD
$memberXgold = Member::getMemberXgold(1);
var_dump($memberXgold);