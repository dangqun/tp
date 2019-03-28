<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/28
 * Time: 16:20
 */

namespace app\index\model;


use think\Model;

class UserColFans extends Model
{
    public function user(){
        return $this->belongsTo('user','id','uid')->field('id,user_name,img');
    }

}