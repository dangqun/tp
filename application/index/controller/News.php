<?php
/**
 * 新闻
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/29
 * Time: 16:58
 */

namespace app\index\controller;


use think\Db;
use think\exception\DbException;

class News extends Base
{
    /**
     * 前置操作
     * 无需登录
     * @var array
     */
    protected $beforeActionList = [
        'isLogin'=>['only'=>'']
    ];

    public function index(){
        return $this->fetch('headlines');
    }

    /**
     * 列表
     */
    public function show(){
        $type = $this->request->has('type') ? intval($this->request->param('type')) : 1;
        $data = [
            'type'=>$type
        ];
        return $this->fetch('headlines',$data);
    }

    /**
     * 详情
     */
    public function showInfo(){
        return $this->fetch('article');
    }

    /************************************************ API分割线 ******************************************************************/

    /**
     * 获取列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function apiList(){
        $map = [];
        try{
            $list = Db::name('new')->where($map)->order('order DESC')->order('id DESC')->page($this->page)->limit($this->size)->select();
        }catch (DbException $e){
            $this->result['error_code'] = 10000;
            $this->result['error_msg'] = $e->getMessage();
            $this->output();
            return;
        }
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
     * 获取资讯详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function apiContent(){
        if(!$this->request->has('id')){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $id = intval($this->request->param('id'));
        try{
            $info = Db::name('new')->find($id);
        }catch (DbException $e){
            $this->result['error_code'] = 10000;
            $this->result['error_msg'] = $e->getMessage();
            $this->output();
            return;
        }
        if(empty($info)){
            $this->result['error_code'] = 8001;
            $this->output();return;
        }
        $this->result['code'] = 200;
        $this->result['data'] = $info;
        $this->output();
    }

}