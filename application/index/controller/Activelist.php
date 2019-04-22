<?php
/**
 * 活动管理
 */

namespace app\index\controller;


class Activelist extends Base
{
    public function index(){
        return $this->fetch('index/activeList');
    }

}