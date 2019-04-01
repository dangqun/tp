<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/28
 * Time: 13:39
 */

namespace app\index\model;


use think\Model;

class Comment extends Model
{

    public function getLikeAttr($value){
        $value = count($value);
        return $value;
    }

    public function getImgAttr($value){
        if(empty($value)){
            return;
        }
        $value = json_decode($value,true);
        return $value;
    }

    public function like(){
        return $this->hasMany('CommentLike','cid','id')->field('id,cid,uid');
    }

    public function user(){
        return $this->belongsTo('User','uid','id')->field('id,user_name,img');
    }

}