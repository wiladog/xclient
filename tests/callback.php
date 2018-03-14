<?php

/**
 *
 * 回调示例
 */
require_once __DIR__ .'/../vendor/autoload.php';

use Xgold\Helper\GzlHttp;

// 接收回调数据
$postData = $_POST;

// 验证签名



if(GzlHttp::checkSign($postData) === true) {
    $data = $postData['data'];

    $results =[];
    foreach ($data as $item) {
        $result =[];
        $result['id'] = $item['id'];
        $result['related'] = $item['related'];
        // 处理自己应用的业务逻辑
        // ......
        // 得到 status  ok 或者  no
        $status = 'ok';
        $result['status'] = $status;
        $results[] = $result;
    }
// 输出结果
    echo json_encode($results);

} else {
    echo 'sign error';
}

