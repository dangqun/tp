<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/29
 * Time: 17:06
 */

namespace app\index\controller;

use think\Db;
use think\Loader;
class Org extends Base
{

    public function index(){
        return 1;
    }

    /************************************************ api分割线 *******************************************************/

    /**
     * 组织列表
     */
    public function apiGetList(){
        $model = Loader::model('Org');
        $list = $model->field('id,name,address,mobile,img')->with('volunteer')->where('status','=','1')->page($this->page)->limit($this->size)->select();
        if(empty($list)){
            $this->result['error_code'] = 3001;
            $this->output();
            return;
        }
        if(!empty($list)){
            $list = collection($list)->toArray();
            foreach($list as $k=>$v){
                $list[$k]['volunteer'] = count($v['volunteer']);
            }
        }
        $this->result['code'] = 200;
        $this->result['data'] = $list;
        $this->output();
    }

    /**
     * 组织详情
     */
    public function apiGetContent(){
        if(!$this->request->has('id')){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $model = Loader::model('Org');
        $id = $this->request->param('id');
        $content = $model->find($id);
        if(empty($content)){
            $this->result['error_code'] = 6002;
            $this->output();
        }
        $vol = $content->volunteer;
        $user = $content->user;
        $content = $content->toArray();
        $content['volunteer'] = count($vol);
        if(empty($vol)){
            $userInfo = Db::name('user')->field('user_name,mobile')->find($user->id);
        }else{
            $userInfo = $vol[0]->field('user_name,mobile')->find($user->id);
        }
        $content['user_info'] = $userInfo;
        $this->result['code'] = 200;
        $this->result['data'] = $content;
        $this->output();
    }

    /**
     * 加入组织
     */
    public function apiJoin(){
        if($this->isLogin(true)){
            return;
        }
        if($this->request->has('id')){
            $this->result['error_code'] = 6003;
            $this->output();
            return;
        }

        if(!empty($this->userInfo['org'])){
            $this->result['error_code'] = 6004;
            $this->output();
            return;
        }
        $id = $this->request->param('id');
        $model = Loader::model('Org');
        $org = $model->field('id,name')->find($id);
        if(empty($org)){
            $this->result['error_code'] = 6005;
            $this->output();
            return;
        }
        if($org->status != 1){
            $this->result['error_code'] = 6006;
            $this->output();
            return;
        }

        $data = [];
        $data['org'] = $org->id;
        $model->startTrans();
        $result = $model->where('id','=',$org->id)->update($data);
        if(empty($result)){
            $model->rollback();
            $this->result['error_code'] = 6007;
            $this->output();
            return;
        }
        $data['uid'] = $this->userInfo['id'];
        $data['type'] = 1;
        $data['content'] = "用户{$this->userInfo['user_name']}于".date('Y-m-d H:i:s',NOW_TIME)."申请加入{$org->name}组织";
        $data['create_time'] = NOW_TIME;
        $result = Db::name('org_user_log')->insert($data);
        if(empty($result)){
            $model->rollback();
            $this->result['error_code'] = 6007;
            $this->output();
            return;
        }
        $model->commit();
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 退出组织
     */
    public function apiOut(){
        if($this->isLogin(true)) return;
        if(!$this->request->has('id')){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $id = intval($this->request->param('id'));
        $uid = $this->userInfo['id'];

    }

}