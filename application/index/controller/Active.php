<?php
/**
 * 发起活动
 */

namespace app\index\controller;


class Active extends Base
{

    public function index(){
        return $this->fetch('index/active');
    }

}