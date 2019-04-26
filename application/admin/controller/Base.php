<?php
/* 
 * 后台控制器基类
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\admin\controller;
use \think\Controller;
use \think\Request;

class Base extends Controller{
    
    protected $result = [
        "code" => 400,
        "msg" => "服务繁忙,请稍后重试!",
        "data" => []
    ];
    protected $request;
    
//    protected function _initialize() {
//        parent::_initialize();
//        if(!\think\Session::has("login","a")){//未登录跳转登录页面
//            $this->redirect('Login/login');
//        }
//        $this->request = Request::instance();
//    }
    
    protected function __output(){
        echo json_encode($this->result,JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * 获取顶部导航
     */
    private function getTop(){
        
    }
    
    /**
     * 获取侧边导航
     */
    private function getLeft(){
        
    }
    
}

