<?php
/**
 * 我的关注
 */

namespace app\index\controller;


class Myconcern extends Base
{

    public function index(){
        return $this->fetch('index/myConcern');
    }

}