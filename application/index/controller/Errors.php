<?php


namespace app\index\controller;


use think\Controller;

class Errors extends Controller
{

    public function index(){
        return $this->fetch('index',['title'=>'错误信息展示']);
    }

}