<?php


namespace app\index\controller;

/**
 * 一些公用的API接口
 * Class Api
 * @package app\index\controller
 */
class Api extends Base
{
    /**
     * 前置操作
     * @var array
     */
    protected $beforeActionList = [
        'isLogin'=>[
//            'only'=>'',//只有这些需要登录
            'except'=>''//这些方法不用登录
        ]
    ];


    /**
     * 收藏
     */
    public function apiCollection()
    {
        if (!$this->request->has('id')) {
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        if(!$this->request->has('type')){//
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $result = \Tools::collection($this->request->param('id'),$this->userInfo['uid'],$this->request->param('type'));
        if($result == -1){
            $this->result['error_code'] = 9002;
            $this->output();
            return;
        }
        if($result == false){
            $this->result['error_code'] = 9001;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 取消收藏
     */
    public function apiCancelCollection()
    {
        if (!$this->request->has('id')) {
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        if(!$this->request->has('type')){//
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $result = \Tools::cancelCollection($this->request->param('id'),$this->userInfo['uid'],$this->request->param('type'));
        if($result == -1){
            $this->result['error_code'] = 9003;
            $this->output();
            return;
        }
        if($result == false){
            $this->result['error_code'] = 9004;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 关注
     */
    public function apiFollow(){
        if (!$this->request->has('id')) {
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        if(!$this->request->has('type')){//
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $result = \Tools::follow($this->request->param('id'),$this->userInfo['uid'],$this->request->param('type'));
        if($result == -1){
            $this->result['error_code'] = 9006;
            $this->output();
            return;
        }
        if($result == false){
            $this->result['error_code'] = 9005;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 取消关注
     */
    public function apiCancelFollow(){
        if (!$this->request->has('id')) {
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        if(!$this->request->has('type')){//
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $result = \Tools::cancelFollow($this->request->param('id'),$this->userInfo['uid'],$this->request->param('type'));
        if($result == -1){
            $this->result['error_code'] = 9007;
            $this->output();
            return;
        }
        if($result == false){
            $this->result['error_code'] = 9008;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

}