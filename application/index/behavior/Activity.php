<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 21:58
 */

namespace app\index\behavior;

use app\index\model\Activity as ActivityModel;
use think\Loader;

class Activity
{
    /**
     * 活动列表
     */
    public function _list(){
        $model = Loader::model('Activity');
        print_r($model);
    }

}