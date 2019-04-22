<?php
/**
 * 活动管理
 */

namespace app\index\controller;


class Conferencetype extends Base
{
    public function index(){
        return $this->fetch('index/conferenceType');
    }

}