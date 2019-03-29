<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/28
 * Time: 9:26
 */

namespace app\index\model;

use think\Model;
class OrgUid extends Model
{



    public function org(){
        return $this->belongsTo('Org','oid','id')->field('id,name');
    }

    public function parents(){
        return $this->hasManyThrough('OrgParent','Org','id','oid','oid');
    }

}