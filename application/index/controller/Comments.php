<?php
/**
 * 评论秀
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 19:41
 */

namespace app\index\controller;


class Comments extends Base
{
    public function index(){
        return $this->fetch('index');
    }

}