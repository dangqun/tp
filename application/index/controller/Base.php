<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 19:42
 */

namespace app\index\controller;


use think\Controller;
use think\Debug;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;
use think\Session;
class Base extends Controller
{
    use \WeChat;

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

    /**
     * 全局用户详情
     * @var array
     */
    protected $userInfo = [];

    /**
     * 页码
     * @var int
     */
    protected $page = 1;

    /**
     * 请求量
     * @var int
     */
    protected $size = 10;

    /**
     * 前置操作
     * @var array
     */
    protected $beforeActionList = [
        'init',
        'initLogin'
    ];

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->request = $request::instance();//请求信息赋值
    }

    /**
     * 初始化
     */
    protected function init(){

        $this->isApi = $this->request->isAjax();//判断是否为AJAX请求

        Session::prefix('dangqun');//设置session作用域

        $status = require_once (APP_PATH.DS.'status.php');//引入状态码文件

        $this->setStatus($status);//初始化状态码

        $this->assign('title','党群');//全局标题设置=

        $this->setPageSize();//设置页码和请求量
    }

    /**
     * 初始化登录信息
     */
    protected function initLogin(){
        if(Session::has('user')){
            $this->setLoginState(true);
            $this->setUserInfo(Session::get('user'));
        }else if($this->isWeiXinBrowser() && !$this->request->isAjax()){
            $weLogin = $this->weLogin();
            if($weLogin == false){
                $this->redirect('Errors/index');
            }
        }
    }

    protected function begin($msg){
        $this->s($msg);
        Debug::remark('begin');
    }

    protected function end($msg){
        Debug::remark('end');
        $this->s($msg);
        $this->f();
    }


    /**
     * 是否登录
     * @param bool $api
     * @return bool
     */
    public function isLogin($api = false){
        if($this->isLoginState()){
            return true;
        }
        if($api){//api则输出JSON
            $this->result['msg'] = '请先登录！';
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
     * 设置页码/请求量
     */
    protected function setPageSize(){
        if($this->request->has('page')){
            $this->page = $this->request->param('page');
        }
        if($this->request->has('size')){
            $this->size = $this->request->param('size');
        }
    }

    /**
     * 是否为微信
     * @return bool
     */
    protected function isWeiXinBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 输出内容
     */
    protected function s($content = null){
        echo $content . "<br/>\r\n";
    }

    protected function f(){
        echo "执行时间：".Debug::getRangeTime('begin','end')."s<br/>\r\n";
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

    /**
     * @return array
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * @param array $userInfo
     */
    public function setUserInfo($userInfo)
    {
        $this->userInfo = $userInfo;
    }





}