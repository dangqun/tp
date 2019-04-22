<?php
/**
 * 发起活动
 */

namespace app\index\controller;


class Pioneerindex extends Base
{

    public function index(){
        return $this->fetch('index/pioneerIndex');
    }

}