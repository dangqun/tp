<?php

/**
 * 会议控制器
 */

namespace app\index\controller;


class Meeting extends Base
{

    /**
     * 首页
     */
    public function index(){
        $type = $this->request->has('type') ? intval($this->request->param('type')) : 0;
        switch ($type){
            case 1://类型1
                return $this->fetch("conferenceList");
                break;
            case 2://类型2
                return $this->fetch("");
                break;
            case 3://类型3
                return $this->fetch("");
                break;
            case 4://类型4
                return $this->fetch("");
                break;
            default://没有类型，则进入选择会议类型页面
                return $this->fetch("conferenceType");
                break;
        }
    }

    /**
     * 列表
     */
    public function show(){
        $this->fetch('');
    }

    /************************************************ api分割线 *******************************************************/

    /**
     * 新增会议记录
     */
    public function apiAddMeetingRecord(){

    }

    /**
     * 编辑会议内容
     */
    public function apiUpdateMeetingRecord(){

    }

    /**
     * 删除会议记录
     */
    public function apiDelMeetingRecord(){

    }

}