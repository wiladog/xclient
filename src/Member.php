<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 07/03/2018
 * Time: 4:55 PM
 */

namespace Xgold;


use Xgold\Helper\GzlHttp;

class Member {


    /**
     * get member xgold
     * @param int $uid
     * @return array
     */
    public static function getMemberXgold($uid) {
        $data = [
            'current_xgold' => 0,
            'income_xgold' => 0,
            'expenditure_xgold' => 0,
        ];

        $url = 'http://xgold.mez100.com.cn/v1/members/point';
        $data = [
            'id' => 7,
            'timestamp' => time()
        ];
        $sign = GzlHttp::getSign($data);
        $data['sign'] = $sign;
        $rsData = GzlHttp::post($url,$data);

        return $rsData['data']['point'];



    }
}