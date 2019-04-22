<?php
/**
 * 活动管理
 */

namespace app\index\controller;


class Conferencelist extends Base
{
    public function index(){
        return $this->fetch('index/ConferenceList');
    }

}