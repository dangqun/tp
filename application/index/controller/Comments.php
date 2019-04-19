<?php
/**
 * 评论秀
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 19:41
 */

namespace app\index\controller;


use app\index\model\Comment;
use app\index\model\CommentLike;
use think\Loader;

class Comments extends Base
{
    public function index(){
        return $this->fetch('index');
    }

    /************************************************** API分割线 ***************************************************************/

    /**
     * 评论列表
     */
    public function apiList(){
        $list = Comment::field('id,uid,content,img')->with('user,like')->page($this->page)->limit($this->size)->select();
        if(empty($list)){
            $this->result['error_code'] = '3001';
            $this->output();
            return;
        }
        $list = $this->doImg($list);
        $this->result['code'] = 200;
        $this->result['data'] = $list;
        $this->output();
    }

    /**
     * 评论列表-类型查询
     */
    public function apiListType(){
        $type = $this->request->has('type') ? intval($this->request->param('type')) : 0;
        $list = Comment::field('id,uid,content,img')->with('user,like')->where(['type'=>$type])->page($this->page)->limit($this->size)->select();
        if(empty($list)){
            $this->result['error_code'] = '3001';
            $this->output();
            return;
        }
        $list = $this->doImg($list);
        $this->result['code'] = 200;
        $this->result['data'] = $list;
        $this->output();
    }

    /**
     * 列表-处理图片
     * @param array $data
     * @return array
     */
    private function doImg($data = []){
        if(empty($data)){
            return $data;
        }
        foreach($data as $k=>$v){
            if(empty($v['img'])){
                continue;
            }
            $imgs = $v->img;
            foreach($imgs as $m=>$n){
                $imgs[$m] = getImgUrl($n);
            }
            $data[$k]->img = json_encode($imgs);
        }
        return $data;
    }

    /**
     * 发布评论
     */
    public function apiAdd(){
        if($this->isLogin(true) !== true){
            return;
        }
        if(!$this->request->has('id')){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        if(!$this->request->has('type')){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $validate = Loader::validate('Comment');
        if(!$validate->check($this->request->param())){
            $this->result['msg'] = $validate->getError();
            $this->output();
            return;
        }
        $data = [
            'obj_id'=>$this->request->param('id'),
            'uid'=>$this->userInfo['id'],
            'content'=>$this->request->param('content'),
            'create_time'=>NOW_TIME
        ];
        if($this->request->has('img')){
            $data['img'] = json_encode($this->request['img']);
        }
        if($this->request->has('parent')){
            $data['parent'] = $this->request->param('parent');
        }
        $result = Comment::create($data);
        if(empty($result)){
            $this->result['error_code'] = 7001;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 点赞
     */
    public function apiLike(){
        if($this->isLogin(true)) return;
        if($this->request->has('id')){
            $this->result['msg'] = 3001;
            $this->output();
            return;
        }
        $id = intval($this->request->param('id'));
        $is = Comment::find($id);
        if(empty($is)){
            $this->result['msg'] = 7001;
            $this->output();
            return;
        }
        $isLike = CommentLike::find(['uid'=>$this->userInfo['id'],'cid'=>$id]);
        if(!empty($isLike)){
            $this->result['error_code'] = 7004;
            $this->output();
            return;
        }
        $data = [];
        $data['cid'] = $id;
        $data['uid'] = $this->userInfo['id'];
        $data['create_time'] = NOW_TIME;
        $result = Comment::create($data);
        if($result == false){
            $this->result['error_code'] = 7002;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 取消点赞
     */
    public function apiCancelLike(){
        if($this->isLogin(true)) return;
        if($this->request->has('id')){
            $this->result['msg'] = 3001;
            $this->output();
            return;
        }
        $id = intval($this->request->param('id'));
        $is = Comment::find($id);
        if(empty($is)){
            $this->result['msg'] = 7001;
            $this->output();
            return;
        }
        $isLike = CommentLike::find(['uid'=>$this->userInfo['id'],'cid'=>$id]);
        if(empty($isLike)){
            $this->result['error_code'] = 7003;
            $this->output();
            return;
        }
        $data = [];
        $data['cid'] = $id;
        $data['uid'] = $this->userInfo['id'];
        $data['create_time'] = NOW_TIME;
        $result = Comment::create($data);
        if($result == false){
            $this->result['error_code'] = 7002;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 删除
     */
    public function del(){
        if($this->isLogin(true))return;
        if($this->request->has('id')){
            $this->result['error_code'] = 3001;
            $this->output();
            return;
        }
        $id = $this->request->param('id');
        $info = Comment::find($id);
        if(empty($info)){
            $this->result['error_code'] = 7001;
            $this->output();
            return;
        }
        if($this->userInfo['id'] != $info['uid']){
            $this->result['error_code'] = 7005;
            $this->output();
            return;
        }
        $result = Comment::delete($info['id']);
        if($result == false){
            $this->result['error_code'] = 3003;
            $this->output();return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

}