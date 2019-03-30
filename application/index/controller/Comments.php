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
        $this->result['code'] = 200;
        $this->result['data'] = $list;
        $this->output();
    }

    /**
     * 评论列表-类型
     */
    public function apiListType(){
        $type = $this->request->has('type') ? intval($this->request->param('type')) : 0;
        $list = Comment::field('id,uid,content,img')->with('user,like')->where(['type'=>$type])->page($this->page)->limit($this->size)->select();
        if(empty($list)){
            $this->result['error_code'] = '3001';
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->result['data'] = $list;
        $this->output();
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

    }

    /**
     * 取消点赞
     */
    public function apiCancelLike(){

    }

}