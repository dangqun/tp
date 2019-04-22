<?php
/**
 * 消息中心
 */

namespace app\index\controller;


class Tip extends Base
{

    public function index(){
        return $this->fetch('index/tip');
    }

}