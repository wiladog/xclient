<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 08/03/2018
 * Time: 4:12 PM
 */
namespace Xgold\Helper;


use GuzzleHttp\Client;

class GzlHttp {

    /**
     * http post 网络请求
     * @param string $url
     * @param array $params
     * @return mixed
     */
    public static function post($url, $params) {

        $client = new Client();

        $response = $client->request('POST', $url, ['form_params' => $params]);
//        echo $res->getStatusCode();
        $rsData = json_decode($response->getBody(),true);
        return $rsData;

    }

    /**
     * 签名
     *
     * @param $data 需要签名的参数数组
     * @param string $key 加密key
     * @return string $sign 生成的签名串
     */
    public static function getSign($data, $key = 'yidingyaobaomi') {
        ksort($data);
        $hbq = http_build_query($data);
        $sign = md5($hbq . $key);

        return $sign;
    }

}