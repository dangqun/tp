<?php
/**
 * 活动管理
 */

namespace app\index\controller;


class Volunteers extends Base
{
    public function index(){
        return $this->fetch('volunteer');
    }

    public function add(){
        return $this->fetch('volunteer');
    }


    /***************************************************  APIf方法  *********************************************************************/

}