<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 09/03/2018
 * Time: 2:07 PM
 */

namespace Xgold;

use Xgold\Helper\GzlHttp;

use Illuminate\Database\Capsule\Manager as Capsule;

class Client {

    /** @var array Default request options */
    protected $config;

    /**
     * Clients accept an array of constructor parameters.
     *
     * Here's an example of creating a client using a base_uri and an array
     *
     *     $client = new Client([
     *         'base_uri'        => 'http://xgold.mez100.com.cn/v1/',
     *         'database'         => [
     *              'driver'    => 'mysql',
     *              'host'      => '192.168.33.10',
     *              'database'  => 'xgold_infinix_dev',
     *              'username'  => 'root',
     *              'password'  => '0.1234',
     *              'charset'   => 'utf8mb4',
     *              'collation' => 'utf8mb4_bin',
     *              'prefix'    => '',
     *          ],
     *     ]);

     */

    public function __construct($config = []) {

        $this->config = $config;
    }

//$url = 'http://xgold.mez100.com.cn/v1/members/point';

    public  function getConfig($key) {
        $xgold_base_url = 'http://xgold.mez100.com.cn/v1/';
        $xgold_base_url = 'http://api.xgold.infinix.test/index.php/v1/';


        $config = $this->config;
        $database = $config['database'];
        $allConfig = [
            'members_point'    => $config['base_uri'] . 'members/point', // 获取用户积分
            'pointlogs_detail' => $config['base_uri'] . 'pointlogs/detail', // 交易查询
            'pointlogs'        => $config['base_uri'] . 'pointlogs', // 积分变更
            'pointlogs_batch'  => $config['base_uri'] . 'pointlogs/batch', // 批量 积分变更
            'database'         => $database,
        ];

        return $allConfig[$key];
    }


    public  function getMemberXgold($uid) {


        $data = [
            'id'        => $uid,
            'timestamp' => time(),
        ];
        $sign = GzlHttp::getSign($data);
        $data['sign'] = $sign;
        $url = $this->getConfig('members_point');
        $rsData = GzlHttp::post($url, $data);

        return $rsData['data']['point'];
    }

    public  function getPointlogsDetail($id) {


        $data = [
            'id'        => $id,
            'timestamp' => time(),
        ];
        $sign = GzlHttp::getSign($data);
        $data['sign'] = $sign;
        $url = $this->getConfig('pointlogs_detail');
        $rsData = GzlHttp::post($url, $data);

        var_dump($rsData);

//        return $rsData['data']['point'];
    }

    public  function pointlogs($uid, $appid, $point, $type, $related) {
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
            $database = $this->getConfig('database');
            $capsule->addConnection($database);
            // 设置全局静态可访问
            $capsule->setAsGlobal();
//            // 启动Eloquent
            $capsule->bootEloquent();
            $cur_time = time();
            $data['created_at'] = $cur_time;
            $data['updated_at'] = $cur_time;

            $rs = Capsule::table('point_logs_queue')->insert([$data]);

            var_dump($rs);

//            pointlogs_batch


        } else {
            $data['sign'] = GzlHttp::getSign($data);
            $rsData = GzlHttp::post($this->getConfig('pointlogs'), $data);
            // 定义超时 返回false;
            var_dump($rsData);
        }


    }


}