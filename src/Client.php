<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 09/03/2018
 * Time: 2:07 PM
 */

namespace Xgold;

use Xgold\Helper\GzlHttp;
use Ramsey\Uuid\Uuid;

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
     *           // Xgold API 地址
     *          'base_uri'                    => 'http://api.xgold.infinix.test/v1/',
     *           // Xgold 中的APPID
     *           'appid'                       => 1,
     *           // Xgold 中的通信密钥
     *           'secret_key'                  => 'yidingyaobaomi',
     *           // 本地积分队列表名称
     *           'point_logs_queue_table_name' => 'point_logs_queue',
     *           // 数据库配置
     *           'database'                    => [
     *              'driver'    => 'mysql',
     *              'host'      => '192.168.33.10',
     *              'database'  => 'xgold_infinix_dev',
     *              'username'  => 'root',
     *              'password'  => '0.1234',
     *              'charset'   => 'utf8mb4',
     *              'collation' => 'utf8mb4_bin',
     *              'prefix'    => '',
     *           ],
     *     ]);
     */

    public function __construct($config = []) {

        $this->config = $config;
    }


    public function getConfig($key) {

        $config = $this->config;
        $database = $config['database'];
        $allConfig = [
            'members_history'             => $config['base_uri'] . 'members/history', // 获取用户积分
            'members_point'               => $config['base_uri'] . 'members/point', // 获取用户积分
            'members_batch_point'         => $config['base_uri'] . 'members/batch/point', // 获取用户积分
            'pointlogs_detail'            => $config['base_uri'] . 'pointlogs/detail', // 交易查询
            'pointlogs'                   => $config['base_uri'] . 'pointlogs', // 积分变更
            'pointlogs_batch'             => $config['base_uri'] . 'pointlogs/batch', // 批量 积分变更
            'pointlogs_alteration'        => $config['base_uri'] . 'pointlogs/alteration', // 积分变更确认
            'database'                    => $database,
            'secret_key'                  => $config['secret_key'],
            'point_logs_queue_table_name' => $config['point_logs_queue_table_name'],
            'appid'                       => $config['appid'],
        ];

        return $allConfig[$key];
    }

    /**
     * check callback
     *
     * @param array $data
     * @return bool
     */
    public function checkCallback($data) {

        $capsule = new Capsule;
        $database = $this->getConfig('database');
        $capsule->addConnection($database);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        // ->where($data)
        $rs = Capsule::table($this->getConfig('point_logs_queue_table_name'))->find(['id' => $data['id']]);

        if ($rs) {
            if ($rs->id == $data['id'] && $rs->point == $data['point'] && $rs->type == $data['type'] && $rs->uid == $data['uid']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getMemberXgoldHistory($uid) {
        $data = [
            'id'        => $uid,
            'appid'     => $this->getConfig('appid'),
            'timestamp' => time(),
        ];
        $sign = GzlHttp::getSign($data, $this->getConfig('secret_key'));
        $data['sign'] = $sign;
        $url = $this->getConfig('members_history');
        $rsData = GzlHttp::post($url, $data);

        return $rsData['data'];
    }


    public function getMemberXgold($uid) {
        $data = [
            'id'        => $uid,
            'appid'     => $this->getConfig('appid'),
            'timestamp' => time(),
        ];
        $sign = GzlHttp::getSign($data, $this->getConfig('secret_key'));
        $data['sign'] = $sign;
        $url = $this->getConfig('members_point');
        $rsData = GzlHttp::post($url, $data);

        return $rsData['data']['point'];
    }

    /**
     * @param string $uids eg. 1-2-3-4
     * @return mixed
     */
    public function getBatchMemberXgold($uids) {
        $data = [
            'uids'      => $uids,
            'appid'     => $this->getConfig('appid'),
            'timestamp' => time(),
        ];
        $sign = GzlHttp::getSign($data, $this->getConfig('secret_key'));
        $data['sign'] = $sign;
        $url = $this->getConfig('members_batch_point');
        $rsData = GzlHttp::post($url, $data);

        return $rsData['data'];
    }

    public function getPointlogsDetail($id) {
        $data = [
            'id'        => $id,
            'appid'     => $this->getConfig('appid'),
            'timestamp' => time(),
        ];
        $sign = GzlHttp::getSign($data, $this->getConfig('secret_key'));
        $data['sign'] = $sign;
        $url = $this->getConfig('pointlogs_detail');
        $rsData = GzlHttp::post($url, $data);

        return $rsData['data'];

    }

    /**
     * 积分确认
     * @param $data
     */
    public function alteration($data) {
        $data['timestamp'] = time();
        $data['appid'] = $this->getConfig('appid');
        $sign = GzlHttp::getSign($data, $this->getConfig('secret_key'));
        $data['sign'] = $sign;
        $url = $this->getConfig('pointlogs_alteration');
        $rsData = GzlHttp::post($url, $data);

        return $rsData['data']['rs'];
    }

    public function pointlogs($uid, $point, $type, $related) {
        $id = Uuid::uuid1()->toString();
        $data = [
            'uid'     => $uid,
            'appid'   => $this->getConfig('appid'),
            'point'   => $point,
            'type'    => $type,
            'related' => $related,
            'id'      => $id,
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
            $rs = Capsule::table($this->getConfig('point_logs_queue_table_name'))->insert([$data]);
            if ($rs) {
                return true;
            } else {
                return false;
            }
        } else {
            $data['timestamp'] = time();
            $data['sign'] = GzlHttp::getSign($data, $this->getConfig('secret_key'));
            $rsData = GzlHttp::post($this->getConfig('pointlogs'), $data);

            if ($rsData['status'] !== true) {
                return false;
            } else {
                return $id;
            }


        }
    }


}