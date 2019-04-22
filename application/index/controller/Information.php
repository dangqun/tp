<?php
/**
 * 党员信息
 */

namespace app\index\controller;


class Information extends Base
{

    public function index(){
        return $this->fetch('index/information');
    }

}