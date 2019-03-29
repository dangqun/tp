<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/28
 * Time: 9:18
 */

namespace app\index\model;


use think\Model;

class Org extends Model
{

    /**
     * 组织中人员
     * @return \think\model\relation\HasMany
     */
    public function volunteer(){
        return $this->hasMany('user','org','id')->field('id,org');
    }

    /**
     * 组织负责人ID
     * @return \think\model\relation\HasOne
     */
    public function user(){
        return $this->hasOne('OrgUid','oid','id')->field('id,uid');
    }

    /**
     * 父级组织id
     * @return \think\model\relation\HasOne
     */
    public function parents(){
        return $this->hasOne('OrgParent','oid','id')->field('id,parents');
    }

}