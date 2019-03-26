<?php
/**
 * 会话控制器
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 20:51
 */

namespace app\index\controller;


class sessions extends Base
{

    public function login(){
        return view('login');
    }

    public function logOut(){

    }

}