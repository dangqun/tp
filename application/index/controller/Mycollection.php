<?php
/**
 * 我的收藏
 */

namespace app\index\controller;


class Mycollection extends Base
{

    public function index(){
        return $this->fetch('index/myCollection');
}

}