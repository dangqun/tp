<?php

/**
 * 会议控制器
 */

namespace app\index\controller;


use think\Loader;

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
//        $validate = Loader::validate('Meeting');
//        if (!$validate->check($this->request->param())) {
//            $this->result['error_code'] = 4001;
//            $this->result['msg'] = $validate->getError();
//            $this->output();
//            return;
//        }
        $data = $this->setData();
        print_r($data);exit;
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


    private function setData(){
        $data = [];
        $param = $this->request->param();
        foreach($param as $k=>$v){
            if(is_numeric($v)){
                $data[$k] = intval($v);
                continue;
            }
            if(is_string($v)){
                $data[$k] = trim($v);
                continue;
            }
            $data[$k] = $v;
        }
        return $data;
    }

}