<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 19:42
 */

namespace app\index\controller;


use think\Loader;

class Activitys extends  Base
{
    public function index(){
        return $this->fetch('index');
    }

    /**
     * 获取活动列表
     */
    public function apiGetList(){
        $model = Loader::model('Activity');
        $list = $model->all();
        print_r($list);
    }

    /**
     * 新增
     */
    public function apiAdd(){

    }

}