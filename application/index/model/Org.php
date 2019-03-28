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

    public function user(){
        return $this->hasOne('OrgUid','id','oid')->field('id,uid');
    }

    public function parents(){
        return $this->hasOne('OrgParent','id','oid')->field('id,parent');
    }

}