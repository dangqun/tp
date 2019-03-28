<?php
namespace app\index\model;

use think\Model;

class User extends Model
{

    /**
     * 用户是否存在
     */
    public function isExist($map = []){
        return $this->field('id')->where($map)->find();
    }

    public function collection(){
        return $this->hasMany('UserColFans','parent_uid','id')->field('id,uid,create_time');
    }

    public function fans(){
        return $this->hasMany('UserColFans','uid','id')->field('id,parent_uid,create_time');
    }

}