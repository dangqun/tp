<?php
/**
 * 党群头条
 */

namespace app\index\controller;


class Headlines extends Base
{

    public function index(){
        return $this->fetch('index/headlines');
    }

}