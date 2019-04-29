<?php

/**
 * 测试类
 */
namespace app\index\controller;


use think\Controller;
class Test extends Controller
{
    use \Upload;

    public function index(){
        return $this->fetch('upload');
    }


}