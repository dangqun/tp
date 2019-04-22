<?php
/**
 * 头条文章
 */

namespace app\index\controller;


class Article extends Base
{

    public function index(){
        return $this->fetch('index/article');
    }

}