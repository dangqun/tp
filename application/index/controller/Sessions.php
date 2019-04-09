<?php
/**
 * 会话
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
    use \Code;


    /**
     * 登录页面
     * @return \think\response\View
     */
    public function login(){
        if($this->isLoginState()){
            $this->redirect('index/Index/index');
        }
        return view('login');
    }

    /**
     * 登出
     */
    public function logOut(){
        Session::delete('user');//清除缓存
        $this->success('登出成功！','Sessions/login');
    }

    /**
     * 登录行为
     */
    public function loginAction(){
        if($this->isLoginState()){
            $this->result['error_code'] = 1004;
            $this->output();
            return;
        }
        $data = [
            'mobile'=>$this->request->param('mobile'),
            'password'=>$this->request->param('password')
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
        if($user['password'] != sha1($data['password'])){
            $this->result['error_code'] = 1002;
            $this->output();
            return;
        }
        Session::set('user',$user);//登录成功设置用户信息缓存
        $this->result['code'] = 200;
        $this->output();
    }



    /**
     * 获取验证码
     */
    public function apiGetCode(){
        $data = ['mobile'=>$this->request->param('mobile')];
        $validate = Loader::validate('User');
        if(!$validate->scene('code')->check($data)){
            $this->result['msg'] = $validate->getError();
            $this->result['error_code'] = 4001;
            $this->output();
            return;
        }
        $code = $this->setCode($data['mobile']);
        $this->result['code'] = 200;
        $this->result['data'] = $code;
        $this->output();
    }

}