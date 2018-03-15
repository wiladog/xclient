<?php

/**
 *
 * 回调示例
 */
require_once __DIR__ .'/../vendor/autoload.php';

use Xgold\Helper\GzlHttp;

// 接收回调数据 ['data']
$postData = $_POST;
//$file = 'log.txt';
//file_put_contents($file,json_encode($postData).PHP_EOL,FILE_APPEND);
/**
 * 回调处理
 * 数据是用POST方式传递过来  可用 json_encode($postData) 查看具体内容
 * 1.需要验证签名
 * 2.签名通过后对数据进行遍历处理  根据 related point 整合自己应用的业务逻辑
 * 3.标识处理结果状态 succeed 或者 failed
 * 4.输出 json_encode($results)
 *
 */

// 验证签名
if(GzlHttp::checkSign($postData) === true) {
    $data = $postData['data'];
    $results =[];
    foreach ($data as $item) {
        $result =[];
        $result['id'] = $item['id'];
        $result['related'] = $item['related'];
        $result['point'] = $item['point'];
        // 处理自己应用的业务逻辑
        // ......
        // 得到 status  succeed 或者  failed
        $result['status'] = 'succeed'; // or failed
        $results[] = $result;
//        file_put_contents($file,json_encode($result).PHP_EOL,FILE_APPEND);
    }
    // 输出
//    file_put_contents($file,json_encode($results).PHP_EOL,FILE_APPEND);
    echo json_encode($results);

} else {
    echo 'sign error';
}

