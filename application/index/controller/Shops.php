<?php
/**
 * 福利商城
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 19:43
 */

namespace app\index\controller;


class Shops extends Base
{

    public function index(){
        return $this->fetch('index');
    }

}