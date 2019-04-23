<?php
/**
 * 活动类
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 19:42
 */

namespace app\index\controller;


use app\index\model\OrgUid;
use think\Db;
use think\Loader;

class Activitys extends Base
{

    use \Upload,\SignAndOut;

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('index');
    }

    /**
     * 详情
     */
    public function show(){
        $data = [
            'id'=>$this->request->param('id')
        ];
        return $this->fetch('show',$data);
    }

    /**
     * 发起活动
     * @return mixed
     */
    public function add(){
        return $this->fetch('active');
    }

    /**
     * 活动管理
     */
    public function manage(){
        return $this->fetch('activeList');
    }

    /************************************************ api分割线 *******************************************************/
    /**
     * 获取活动列表
     */
    public function apiGetList()
    {
        $model = Loader::model('Activity');
        $list = $model->field('id,oid,uid,title,img,create_time')->with('org')->where('status', '=', '1')->order('create_time DESC')->page($this->page)->limit($this->size)->select();
        if (empty($list)) {
            $this->result['error_code'] = 3001;
            $this->output();
            return;
        }
        foreach($list as $k=>$v){
            $list[$k]['img'] = getImgUrl($v['img']);
        }
        $this->result['code'] = 200;
        $this->result['data'] = $list;
        $this->output();
    }

    /**
     * 精品活动
     */
    public function apiGetSelectedList(){
        $this->errorR('没有更多数据了');
    }

    /**
     * 活动详情
     */
    public function apiGetContent()
    {
        if (!$this->request->has('id')) {
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $id = $this->request->param('id');
        $model = Loader::model('Activity');
        $info = $model->field('id,oid,uid,title,img')->find($id);
        if (empty($info)) {
            $this->result['error_code'] = 5007;
            $this->output();
            return;
        }
        $info->org;
        $info->user;
        $info = $info->toArray();
        $join = $this->getJoinUser($id);
        if ($join != false) {
            $info['join'] = collection($join)->toArray();
        }
        $this->result['code'] = 200;
        $this->result['data'] = $info;
        $this->output();
    }

    /**
     * 活动报名
     */
    public function apiJoin()
    {
        if (!$this->isLogin(true)) {
            return;
        }
        if (!$this->request->has('id')) {
            $this->result['error_code'] = 5008;
            $this->output();
            return;
        }
        $model = Loader::model('ActivityJoin');
        $map = [];
        $map['uid'] = $this->userInfo['id'];
        $map['aid'] = $this->request->param('id');
        $map['del'] = 0;
        $is = $model->field('id')->where($map)->find();
        if (!empty($is)) {
            $this->result['error_code'] = 5010;
            $this->output();
            return;
        }
        $data = [];
        $data['uid'] = $this->userInfo['id'];
        $data['aid'] = $this->request->param('id');
        $data['create_time'] = time();
        $result = $model->insert($data);
        if (empty($result)) {
            $this->result['error_code'] = 5009;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 取消报名
     */
    public function apiUnJoin()
    {
        if (!$this->isLogin(true)) {
            return;
        }
        if (!$this->request->has('id')) {
            $this->result['error_code'] = 5008;
            $this->output();
            return;
        }
        $model = Loader::model('ActivityJoin');
        $map = [];
        $map['uid'] = $this->userInfo['id'];
        $map['aid'] = $this->request->param('id');
        $map['del'] = 0;
        $is = $model->field('id')->where($map)->find();
        if (empty($is)) {
            $this->result['error_code'] = 5011;
            $this->output();
            return;
        }
        $data = [
            'del' => NOW_TIME
        ];
        $result = $model->where($is)->update($data);
        if (empty($result)) {
            $this->result['error_code'] = 5009;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }


    /**
     * 报名用户数据
     * @param int $id
     * @return array|bool
     */
    private function getJoinUser($id = 0)
    {
        if (empty($id)) {
            return false;
        }
        $model = Loader::model('ActivityJoin');
        $map = [
            'aid' => $id,
            'status' => 1,
            'del' => 0
        ];
        $list = $model->field('id,aid,uid')->with('user')->where($map)->order('id DESC')->page($this->page)->limit($this->size)->select();
        if (empty($list)) {
            return false;
        }
        $data = [];
        $list = collection($list)->toArray();
        foreach ($list as $k => $v) {
            $data[] = $v['user'];
        }
        return $data;
    }

    /**
     * 收藏
     */
    public function apiCollection()
    {
        if (!$this->isLogin(true)) return;
        if (!$this->request->has('aid')) {
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $result = \Tools::collection($this->request->param('aid'),$this->userInfo['uid']);
        if($result == -1){
            $this->result['error_code'] = 5004;
            $this->output();
            return;
        }
        if($result == false){
            $this->result['error_code'] = 5003;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();

//        $map = [
//            'aid' => $this->request->param('aid'),
//            'uid' => $this->userInfo['id'],
//            'del' => 0
//        ];
//        $is = Db::name('activity_collection')->where($map)->find();
//        if (!empty($is)) {
//            $this->result['error_code'] = 5004;
//            $this->output();
//            return;
//        }
//        $data = [
//            'aid' => $this->request->param('aid'),
//            'uid' => $this->userInfo['id'],
//            'create_time' => NOW_TIME
//        ];
//        $result = Db::name('activity_collection')->insert($data);
//        if (empty($result)) {
//            $this->result['error_code'] = 5003;
//            $this->output();
//            return;
//        }
//        $this->result['code'] = 200;
//        $this->output();
    }

    /**
     * 取消收藏
     */
    public function apiCancelCollection()
    {
        if (!$this->isLogin(true)) return;
        if (!$this->request->has('aid')) {
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }

        $result = \Tools::cancelCollection($this->request->param('aid'),$this->userInfo['uid']);
        if($result == -1){
            $this->result['error_code'] = 5005;
            $this->output();
            return;
        }
        if($result == false){
            $this->result['error_code'] = 5006;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();

//        $map = [
//            'aid' => $this->request->param('aid'),
//            'uid' => $this->userInfo['id'],
//            'del' => 0
//        ];
//        $is = Db::name('activity_collection')->field('id')->where($map)->find();
//        if (empty($is)) {
//            $this->result['error_code'] = 5005;
//            $this->output();
//            return;
//        }
//        $data = [
//            'del' => NOW_TIME
//        ];
//        $result = Db::name('activity_collection')->where("id", '=', $is['id'])->update($data);
//        if (empty($result)) {
//            $this->result['error_code'] = 5006;
//            $this->output();
//            return;
//        }
//        $this->result['code'] = 200;
//        $this->output();
    }

    /**
     * 新增
     */
    public function apiAdd()
    {
        if (!$this->isLogin(true)) {
            return;
        }
        $validate = Loader::validate('Activity');
        if (!$validate->check($this->request->param())) {
            $this->result['error_code'] = 4001;
            $this->result['msg'] = $validate->getError();
            $this->output();
            return;
        }
        $data = [
            'title' => $this->request->param('title'),
            'img' => $this->request->param('img'),
            'type' => $this->request->param('type'),
            'address' => $this->request->param('address'),
            'start_time' => $this->request->param('start_time'),
            'end_time' => $this->request->param('end_time'),
            'content' => $this->request->param('content'),
            'details' => $this->request->param('details'),
            'lng' => $this->request->param('lng'),
            'lat' => $this->request->param('lat'),
            'range' => $this->request->param('range'),
            'create_time' => NOW_TIME
        ];
        $data['uid'] = $this->userInfo['id'];
        $model = Loader::model('Activity');
        if ($model->oftenAdd($data['uid'], 10)) {
            $this->result['error_code'] = '10001';
            $this->output();
            return;
        }
        $orgUid = OrgUid::get(['uid' => $data['uid'], 'del' => 0]);
        if (empty($orgUid)) {
            $this->result['error_code'] = 5001;
            $this->output();
            return;
        }
        $data['oid'] = $orgUid->oid;
        $result = $model->save($data);
        if (empty($result)) {
            $this->result['error_code'] = 5002;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /***************************************************  内部方法  *********************************************************************/

}