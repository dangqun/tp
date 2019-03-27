<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return view('index');
    }

    /**
     * 个人资料
     */
    public function show(){
        $this->fetch('hello',['name'=>'thinkphp']);
    }

    /**
     * 设置
     */
    public function setting(){

    }



    /***************************************************  APIf方法  *********************************************************************/
}
