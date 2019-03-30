<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/30
 * Time: 8:51
 */

namespace app\index\model;


use think\Model;

class ActivityJoin extends Model
{

    public function activity(){
        return $this->belongsTo('Activity','aid','id')->field('id,title,oid');
    }

    public function user(){
        return $this->hasOne('user','id','uid')->field('id,user_name,img');
    }

}