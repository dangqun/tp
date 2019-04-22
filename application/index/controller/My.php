<?php
/**
 * 我的
 */

namespace app\index\controller;


class My extends Base
{

    public function index(){
        return $this->fetch('index/my');
    }

}