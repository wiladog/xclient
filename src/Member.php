<?php
/**
 * Created by PhpStorm.
 * User: wiladog
 * Date: 07/03/2018
 * Time: 4:55 PM
 */

namespace Xgold;


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

        return $data;
    }
}