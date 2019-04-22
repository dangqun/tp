<?php
/**
 * 活动管理
 */

namespace app\index\controller;


class conferencerecords extends Base
{
    public function index(){
        return $this->fetch('index/conferenceRecords');
    }

}