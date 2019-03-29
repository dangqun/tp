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

    public function volunteer(){
        return $this->hasMany('user','org','id')->field('id,org');
    }

    public function user(){
        return $this->hasOne('OrgUid','oid','id')->field('id,uid');
    }

    public function parents(){
        return $this->hasOne('OrgParent','oid','id')->field('id,parents');
    }

}