<?php
/**
 * 首页
 */
namespace app\index\controller;

use think\Db;
use think\Loader;

class Index extends Base
{
    public function index()
    {
        $slide = $this->getSlide();
        $slide = empty($slide) ? [] : $slide;
        $list = $this->getList();
        $data = [
            'id'=>1,
            'slide'=>$slide,
            'activity'=>$list
        ];
        return view('index',$data);
    }

    /**
     * 我调试用的代码块，别动
     * @return mixed
     */
    public function test(){
        return $this->fetch('welfare');
    }

    /***************************************************  API方法  *********************************************************************/

    /**
     * 获取幻灯片
     */
    public function apiGetSlide(){
        $list = $this->getSlide();
        if(empty($list)){
            $this->errorR('没有幻灯片了');
        }
        $this->successR('请求成功',$list);
    }


    /***************************************************  内部方法  *********************************************************************/

    /**
     * 获取幻灯片
     */
    private function getSlide(){
        $list = Db::name('slide')->field(['title','img','url'])
            ->where(['type'=>0,'del'=>0])->order("sort DESC")
            ->page($this->page)->limit($this->size)->select();
        return $list;
    }

    /**
     * 获取活动列表
     */
    private function getList()
    {
        $model = Loader::model('Activity');
        $list = $model->field('id,oid,uid,title,img,create_time')->
        with('org')->where('status', '=', '1')->order('create_time DESC')->page($this->page)->limit($this->size)->select();
        return $list;
    }
}
