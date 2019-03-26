<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 19:42
 */

namespace app\index\controller;

use app\index\controller\Base;
use think\Db;

class Users extends Base
{

    /**
     * 用户中心首页
     * @return \think\response\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * 个人资料
     */
    public function show()
    {
        $content = Db::table('activity')->field('user_name')->where('')->find();
        return $this->fetch('show',['name'=>'bin']);
    }

    /**
     * 注册
     */
    public function register(){
        return view('register');
    }

    /**
     * 设置
     */
    public function setting(){
        $this->output();
    }

    /***************************************************  APIf方法  *********************************************************************/


}