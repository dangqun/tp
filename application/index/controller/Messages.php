<?php
namespace app\index\controller;
/**
 * 消息类
 */
class Messages extends Base
{

    public function index(){
        return $this->fetch('tip');
    }

}