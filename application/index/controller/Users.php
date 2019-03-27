<?php
/**
 * 用户
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 19:42
 */

namespace app\index\controller;

use app\index\controller\Base;
use think\Db;
use think\Loader;
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
        $data = [
            'mobile'=>$this->request->param('mobile'),
            'password'=>$this->request->param('password'),
            'repassword'=>$this->request->param('repassword')
        ];
        $validate = Loader::validate('User');
        if(!$validate->scene('register')->check($data)){
            $this->result['msg'] = $validate->getError();
            $this->result['error_code'] = 4001;
            $this->output();
            return;
        }
        if(!$this->checkCode($this->request->param('mobile'),$this->request->param('code'))){
            $this->result['msg'] = $this->codeMsg;
            $this->output();
            return;
        }
        $map = [
            'mobile'=>$data['mobile']
        ];
        $user = Loader::model('User');
        if($user->isExist($map) != null){
            $this->result['error_code'] = 1003;
            $this->output();
            return;
        }
        $user->mobile = $data['mobile'];
        $user->password = sha1($data['password']);
        $user->user_name = 'bin'.NOW_TIME;
        $user->bulid_type = 1;
        $user->create_time = NOW_TIME;
        $result = $user->save();
        if(empty($result)){
            $this->result['error_code'] = 1004;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->result['msg'] = '注册成功!';
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