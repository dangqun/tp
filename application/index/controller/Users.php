<?php
namespace app\index\controller;
/**
 * 用户
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 19:42
 */
use app\index\controller\Base;
use app\index\model\User;
use think\Db;
use think\Loader;
use think\Request;

class Users extends Base
{

    use \Upload,\Code;

    /**
     * 前置操作
     * @var array
     */
    protected $beforeActionList = [
        'init',
        'initLogin',
        'isLogin'=>[
            'except'=>'apiRegister,register'
        ]
    ];

    /**
     * 用户中心首页
     * @return \think\response\View
     */
    public function index()
    {
        $id = 2;
        $user = Loader::model('User');
        $user = $user->find($id);
        if($user == null){
            $this->logOut();
        }
        if($user->img == null){
            $user->img = 'static/image/my/head.png';
        }
        $col = $user->follow()->where('del','0')->select();
        $fans = $user->fans()->where(['del'=>0])->select();
        $user = $user->toArray();
        $user['col'] = count($col);
        $user['fans'] = count($fans);
        $data = [
            'user'=>$user
        ];
        return view('index',$data);
    }

    public function score(){
        return $this->fetch('pioneerIndex');
    }

    /**
     * 个人资料
     */
    public function show()
    {
        $this->isLogin();
        $content = Db::name('user')->field('user_name')->find($this->userInfo['id']);
        return $this->fetch('show',['content'=>$content]);
    }

    /**
     * 党员信息
     */
    public function info(){
        return $this->fetch('information');
    }

    /**
     * 关注
     */
    public function follow(){
        $user = Loader::model('User');
        $content = $user->find($this->userInfo['id']);
        $list = $content->follow;
        $data = [];
        if(!empty($list)){
            $uids = [];
            foreach($list as $k=>$v){
                $uids[] = $v->uid;
            }
            $map = [
                'id'=>['in',$uids]
            ];
            $userList = $user->field('id,user_name,img')->where($map)->select();
            if(!empty($userList)){
                foreach($userList as $k=>$v){
                    $userList[$k]['img'] = empty($v['img']) ? getDefaultImg() : $v['img'];
                }
            }
            $data = $userList;
        }
        return $this->fetch('myConcern',['data'=>$data]);
    }

    /**
     * 收藏
     */
    public function collection(){
        $user = Loader::model('User');
        $content = $user->find($this->userInfo['id']);
        $list = $content->collection()->where('del',0)->select();
        $data = [];
        if(!empty($list)){
            $obj_id = [];
        }
        return $this->fetch('myCollection',['data'=>$data]);
    }

    /**
     * 粉丝
     */
    public function fans(){
        return $this->fetch('myFans');
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
     * 用户关注
     */
    public function apiGetCollection(){
        $user = Loader::model('User');
        $content = $user->find($this->userInfo['id']);
        $list = $content->hasWhere('collection',['del'=>0]);
        print_r($list);exit;
        if(empty($list)){
            $this->result['error_code'] = '3001';
            $this->output();
            return;
        }
        $uids = [];
        foreach($list as $k=>$v){
            $uids[] = $v->uid;
        }
        $map = [
            'id'=>['in',$uids]
        ];
        $userList = $user->field('id,user_name,img')->where($map)->select();
        if(empty($userList)){
            $this->result['error_code'] = '3001';
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->result['data'] = $userList;
        $this->output();
    }

    /**
     * 用户粉丝
     */
    public function apiGetFans(){
        $user = Loader::model('User');
        $content = $user->find($this->userInfo['id']);
        $list = $content->fans;
        if(empty($list)){
            $this->result['error_code'] = '3001';
            $this->output();
            return;
        }
        $uids = [];
        foreach($list as $k=>$v){
            $uids[] = $v->parent_uid;
        }
        $map = [
            'id'=>['in',$uids]
        ];
        $userList = $user->field('id,user_name,img')->where($map)->select();
        if(empty($userList)){
            $this->result['error_code'] = '3001';
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->result['data'] = $userList;
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
        $user = Loader::model('User');
    }

    /**
     * 上传图片-头像
     */
    public function apiUpload(){

    }

}