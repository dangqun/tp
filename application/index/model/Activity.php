<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 21:59
 */

namespace app\index\model;


use think\Model;

class Activity extends Model
{

    /**
     * 频繁新增判断
     * 10分钟内只能插入3次
     */
    public function oftenAdd($uid = 0,$time = 600){
        if(empty($uid)){
            return false;
        }
        $startTime = NOW_TIME - $time;
        $endTime = NOW_TIME;
        $map = [
            'uid'=>$uid,
            'create_time'=>['between',[$startTime,$endTime]]
        ];
        $count = $this->where($map)->count('id');
        if($count >= 3){
            return true;
        }
        return false;
    }

    public function org(){
        return $this->belongsTo('Org','oid','id')->field('id,name');
    }

}