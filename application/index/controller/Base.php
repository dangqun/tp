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
    protected $result = [
        'code'=>200,
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
    protected $isLogin = false;

    /**
     * 请求信息
     * @var Request|null
     */
    protected $request = null;

    protected $status = [];

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->request = $request::instance();
        $this->isApi = $this->request->isAjax();
        Session::prefix('dangqun');//设置session作用域
        $status = require_once (APP_PATH.DS.'status.php');
        $this->setStatus($status);
    }

    /**
     * 是否登录
     */
    protected function isLogin(){
        if(Session::has('id')){
            $this->isLogin = true;
        }
    }

    /**
     * 输出
     */
    protected function output(){
        $this->result['msg'] = $this->status[$this->result['code']];
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


}