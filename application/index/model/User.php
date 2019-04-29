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

    /**
     * 用户关注
     * @return \think\model\relation\HasMany
     */
    public function follow(){
        return $this->hasMany('UserColFans','parent_uid','id')->field('id,uid,create_time');
    }

    /**
     * 用户粉丝
     * @return \think\model\relation\HasMany
     */
    public function fans(){
        return $this->hasMany('UserColFans','uid','id')->field('id,parent_uid,create_time');
    }


    /**
     * 用户关注
     * @return \think\model\relation\HasMany
     */
    public function collection(){
        return $this->hasMany('Collection','uid','id')->field('id,obj_id,uid,type,create_time');
    }

}