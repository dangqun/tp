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
use think\Loader;
use think\Request;
class Users extends Base
{

    use \Upload,\Code;

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
        $this->isLogin();
        $content = Db::table('activity')->field('user_name')->where('')->find();
        return $this->fetch('show',['name'=>'bin']);
    }

    /**
     * 注册
     */
    public function register(){
        echo $this->setCode();
        return view('register');
    }

    /**
     * 设置
     */
    public function setting(){
        return $this->fetch('setting');
    }



    /***************************************************  API方法  *********************************************************************/

    /**
     * 注册
     */
    public function apiRegister(){
        $validate = Loader::validate('User');
        if(!$validate->scene('register')->check($this->request)){
            $this->result['error_code'] = 4001;
            $this->output();
            return;
        }
        $data = [
            'mobile'=>$this->request['mobile'],
            'password'=>sha1($this->request['password']),
        ];
    }

    /**
     * 用户详情
     */
    public function apiGetUserContent(){

    }

    /**
     * 用户资料修改
     */
    public function apiSetUserContent(){

    }

    /**
     * 用户排行榜
     */
    public function apiGetUserRanking(){

    }

    /**
     * 用户收藏
     */
    public function apiGetUserCollection(){

    }

    /**
     * 上传图片-头像
     */
    public function apiUpload(){

    }

}