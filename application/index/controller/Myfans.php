<?php
/**
 * 我的粉丝
 */

namespace app\index\controller;


class Myfans extends Base
{

    public function index(){
        return $this->fetch('index/myFans');
    }

}