<?php
/**
 * 会话控制器
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 20:51
 */

namespace app\index\controller;


use think\Db;
use think\Loader;
use think\Session;

class sessions extends Base
{

    /**
     * 登录页面
     * @return \think\response\View
     */
    public function login(){
        return view('login');
    }

    /**
     * 登录行为
     */
    public function loginAction(){
        $data = [
            'mobile'=>$this->request['mobile'],
            'password'=>$this->request['password'],
            'repassword'=>$this->request['repassword'],
            'token'=>$this->request['token']
        ];
        $validate = Loader::validate('User');//加载用户验证类
        if(!$validate->scene('login')->check($data)){//验证失败，返回错误信息
            $this->result['error_code'] = 4001;
            $this->result['msg'] = $validate->getError();
            $this->output();
            return;
        }
        $where = [];
        $where['mobile'] = $data['mobile'];
        $user = Db::name('user')->where($where)->find();
        if(empty($user)){
            $this->result['error_code'] = 1001;
            $this->output();
            return;
        }
        if($user['password'] != md5($data['password'])){
            $this->result['error_code'] = 1002;
            $this->output();
            return;
        }
        Session::set('user',$user);//登录成功设置用户信息缓存
        $this->result['code'] = 200;
        $this->result['error_code'] = 1000;
        $this->output();
    }

    /**
     * 登出
     */
    public function logOut(){
        Session::delete('user');//清除缓存
        $this->success('登出成功！','Sessions/login');
    }

}