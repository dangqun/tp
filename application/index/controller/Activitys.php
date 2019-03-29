<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 19:42
 */

namespace app\index\controller;


use app\index\model\Org;
use app\index\model\OrgUid;
use think\Db;
use think\Loader;

class Activitys extends  Base
{

    use \Upload;

    public function index(){
        return $this->fetch('index');
    }


    /************************************************ api分割线 *******************************************************/


    /**
     * 获取活动列表
     */
    public function apiGetList(){
        $model = Loader::model('Activity');
        $list = $model->field('id,oid,uid,title,img')->with('org')->where('status','=','1')->page($this->page)->limit($this->size)->select();
        if(empty($list)){
            $this->result['error_code'] = 3001;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->result['data'] = $list;
        $this->output();
    }

    /**
     * 活动详情
     */
    public function apiGetContent(){

    }

    /**
     * 收藏
     */
    public function apiCollection(){
        if(!$this->isLogin(true)) return;
        if(!$this->request->has('aid')){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $map = [
            'aid'=>$this->request->param('aid'),
            'uid'=>$this->userInfo['id'],
            'del'=>0
        ];
        $is = Db::name('activity_collection')->where($map)->find();
        if(!empty($is)){
            $this->result['error_code'] = 5004;
            $this->output();
            return;
        }
        $data = [
            'aid'=>$this->request->param('aid'),
            'uid'=>$this->userInfo['id'],
            'create_time'=>NOW_TIME
        ];
        $result = Db::name('activity_collection')->insert($data);
        if(empty($result)){
            $this->result['error_code'] = 5003;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 取消收藏
     */
    public function apiCancelCollection(){
        if(!$this->isLogin(true)) return;
        if(!$this->request->has('aid')){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $map = [
            'aid'=>$this->request->param('aid'),
            'uid'=>$this->userInfo['id'],
            'del'=>0
        ];
        $is = Db::name('activity_collection')->field('id')->where($map)->find();
        if(empty($is)){
            $this->result['error_code'] = 5005;
            $this->output();
            return;
        }
        $data = [
            'del'=>NOW_TIME
        ];
        $result = Db::name('activity_collection')->where("id",'=',$is['id'])->update($data);
        if(empty($result)){
            $this->result['error_code'] = 5006;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 新增
     */
    public function apiAdd(){
        if($this->isLogin(true) !== true){
            return;
        }
        $validate = Loader::validate('Activity');
        if(!$validate->check($this->request->param())){
            $this->result['error_code'] = 4001;
            $this->result['msg'] = $validate->getError();
            $this->output();
            return;
        }
        $data = [
            'title'=>$this->request->param('title'),
            'img'=>$this->request->param('img'),
            'type'=>$this->request->param('type'),
            'address'=>$this->request->param('address'),
            'start_time'=>$this->request->param('start_time'),
            'end_time'=>$this->request->param('end_time'),
            'content'=>$this->request->param('content'),
            'details'=>$this->request->param('details'),
            'lng'=>$this->request->param('lng'),
            'lat'=>$this->request->param('lat'),
            'range'=>$this->request->param('range'),
            'create_time'=>NOW_TIME
        ];
        $data['uid'] = $this->userInfo['id'];
        $model = Loader::model('Activity');
        if($model->oftenAdd($data['uid'],10)){
            $this->result['error_code'] = '10001';
            $this->output();
            return;
        }
        $orgUid = OrgUid::get(['uid'=>$data['uid'],'del'=>0]);
        if(empty($orgUid)){
            $this->result['error_code'] = 5001;
            $this->output();
            return;
        }
        $data['oid'] = $orgUid->oid;
        $result = $model->save($data);
        if(empty($result)){
            $this->result['error_code'] = 5002;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

}