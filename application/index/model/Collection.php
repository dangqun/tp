<?php


namespace app\index\model;


use think\Model;

class Collection extends Model
{
    public function user(){
        return $this->belongsTo('user','id','uid')->field('id,user_name,img');
    }
}