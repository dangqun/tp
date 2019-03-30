<?php
/**
 * 活动行为类
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 21:58
 */

namespace app\index\behavior;

use app\index\model\OrgUid;
use think\Loader;

class Activity extends Base
{

    /**
     * 签到
     */
    public function sign(){

    }

    /**
     * 签退
     */
    public function signOut(){

    }

    /**
     * 报名
     */
    public function join(){

    }

    /**
     * 取消报名
     */
    public function cancelJoin(){

    }

    /**
     * 收藏
     */
    public function collection(){

    }

    /**
     * 取消收藏
     */
    public function cancelCollection(){

    }

    /**
     * 新增
     */
    public function add($data){
        $model = Loader::model('Activity');
        if($model->oftenAdd($data['uid'],10)){
            $this->result['error_code'] = '10001';
            $this->output();
            return;
        }
        $orgUid = OrgUid::get(['uid'=>$data['uid'],'del'=>0]);
        if(empty($orgUid)){
            $this->result['error_code'] = 5001;
            $this->output();
            return;
        }
        $data['oid'] = $orgUid->oid;
        $result = $model->save($data);
        if(empty($result)){
            $this->result['error_code'] = 5002;
            $this->output();
            return;
        }
        $this->result['code'] = 200;
        $this->output();
    }

}