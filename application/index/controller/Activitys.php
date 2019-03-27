<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 19:42
 */

namespace app\index\controller;


class Activitys extends  Base
{
    public function index(){
        return $this->fetch('index');
    }

}