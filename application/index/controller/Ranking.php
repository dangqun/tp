<?php
/**
 * 发起活动
 */

namespace app\index\controller;


class Ranking extends Base
{

    public function index(){
        return $this->fetch('index/ranking');
    }

}