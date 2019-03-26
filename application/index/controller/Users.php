<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 19:42
 */

namespace app\index\controller;

use app\index\controller\Base;
class Users extends Base
{

    public function index()
    {
        return view('index');
    }

    /**
     * 个人资料
     */
    public function show()
    {
        return $this->fetch('show',['name'=>'bin']);
    }

    /**
     * 设置
     */
    public function setting(){
        $this->output();
    }

    /***************************************************  APIf方法  *********************************************************************/


}