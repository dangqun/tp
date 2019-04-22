<?php
/**
 * 公益秀
 */

namespace app\index\controller;


class Welfare extends Base
{

    public function index(){
        return $this->fetch('index/welfare');
    }

}
