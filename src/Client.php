<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 09/03/2018
 * Time: 2:07 PM
 */

namespace Xgold;

use Xgold\Helper\GzlHttp;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;//如果你不喜欢这个名称，as DB;就好

class Client {

//$url = 'http://xgold.mez100.com.cn/v1/members/point';

    public static function getConfig($key) {
        $xgold_base_url = 'http://xgold.mez100.com.cn/v1/';
        $xgold_base_url = 'http://api.xgold.infinix.test/index.php/v1/';

        $database = [
            'driver'    => 'mysql',
            'host'      => '192.168.33.10',
            'database'  => 'xgold_infinix_dev',
            'username'  => 'root',
            'password'  => '0.1234',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_bin',
            'prefix'    => '',
        ];
        $allConfig = [
            'members_point'    => $xgold_base_url . 'members/point', // 获取用户积分
            'pointlogs_detail' => $xgold_base_url . 'pointlogs/detail', // 交易查询
            'pointlogs'        => $xgold_base_url . 'pointlogs', // 积分变更
            'pointlogs_batch'  => $xgold_base_url . 'pointlogs/batch', // 批量 积分变更
            'database'         => $database,
        ];

        return $allConfig[$key];
    }


    public static function getMemberXgold($uid) {


        $data = [
            'id'        => $uid,
            'timestamp' => time(),
        ];
        $sign = GzlHttp::getSign($data);
        $data['sign'] = $sign;
        $url = self::getConfig('members_point');
        $rsData = GzlHttp::post($url, $data);

        return $rsData['data']['point'];
    }

    public static function getPointlogsDetail($id) {


        $data = [
            'id'        => $id,
            'timestamp' => time(),
        ];
        $sign = GzlHttp::getSign($data);
        $data['sign'] = $sign;
        $url = self::getConfig('pointlogs_detail');
        $rsData = GzlHttp::post($url, $data);

        var_dump($rsData);

//        return $rsData['data']['point'];
    }

    public static function pointlogs($uid, $appid, $point, $type, $related) {
        $data = [
            'uid'     => $uid,
            'appid'   => $appid,
            'point'   => $point,
            'type'    => $type,
            'related' => $related,
        ];


        if ($type == 1) {


            $capsule = new Capsule;

            // 创建链接
            $database = self::getConfig('database');
            $capsule->addConnection($database);
            // 设置全局静态可访问
            $capsule->setAsGlobal();
//            // 启动Eloquent
            $capsule->bootEloquent();
//            $cur_time = time();
//            $data['created_at'] = $cur_time;
//            $data['updated_at'] = $cur_time;

            $plqs = $capsule::table('point_logs_queue')->limit(100)->get();
            $tmp = '';
            foreach ($plqs as $plq) {
                $tmp .= $plq->uid.'-'.$plq->appid.'-'.$plq->point.'-'.$plq->type.'-'.$plq->related.',';
            }
            $tmp = substr($tmp, 0, -1);

            $tmpData = [
                'batch_data' => $tmp,
                'timestamp' => time(),
            ];
            $tmpData['sign'] = GzlHttp::getSign($tmpData);

            $rsData = GzlHttp::post(self::getConfig('pointlogs_batch'), $tmpData);

            var_dump($rsData);


//            pointlogs_batch


        } else {
            $data['sign'] = GzlHttp::getSign($data);
            $rsData = GzlHttp::post(self::getConfig('pointlogs'), $data);
            // 定义超时 返回false;
            var_dump($rsData);
        }


    }


}