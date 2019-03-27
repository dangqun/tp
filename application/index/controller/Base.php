<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 19:42
 */

namespace app\index\controller;


use think\Controller;
use think\Request;
use think\Session;
class Base extends Controller
{
    /**
     * ajax请求输出结构
     * @var array
     */
    protected $result = [
        'code'=>400,
        'msg'=>'',
        'data'=>[]
    ];

    /**
     * 是否接口请求
     * @var bool
     */
    protected $isApi = false;

    /**
     * 是否登录
     * @var bool
     */
    protected $loginState = false;

    /**
     * 请求信息
     * @var Request|null
     */
    protected $request = null;

    /**
     * 全局状态码
     * @var array
     */
    protected $status = [];

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        $this->request = $request::instance();//请求信息赋值

        $this->isApi = $this->request->isAjax();//判断是否为AJAX请求

        Session::prefix('dangqun');//设置session作用域

        $status = require_once (APP_PATH.DS.'status.php');//引入状态码文件

        $this->setStatus($status);//初始化状态码

        $this->assign('title','党群');//全局标题设置
    }


    /**
     * 是否登录
     */
    public function isLogin($api = false){
        if($this->isLoginState()){
            return true;
        }
        if($api){//api则输出JSON
            $this->output();
        }else{//页面则跳转至登录
            $this->redirect('Sessions/login');
        }
    }


    /**
     * 输出
     */
    protected function output(){
        if(empty($this->result['msg'])){
            if($this->result['code'] == 200){
                $this->result['msg'] = $this->status[$this->result['code']];
            }else{
                $this->result['msg'] = isset($this->status[$this->result['error_code']]) ? $this->status[$this->result['error_code']] : '请求成功';
            }
        }
        return json($this->result)->send();
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param array $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isLoginState()
    {
        return $this->loginState;
    }

    /**
     * @param bool $loginState
     */
    public function setLoginState($loginState)
    {
        $this->loginState = $loginState;
    }





}