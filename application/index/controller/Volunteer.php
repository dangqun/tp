<?php
/**
 * 活动管理
 */

namespace app\index\controller;


class Volunteer extends Base
{
    public function index(){
        return $this->fetch('index/volunteer');
    }

}