<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/28
 * Time: 14:21
 */

namespace app\index\model;


use think\Model;

class CommentLike extends Model
{

    public function comments(){
        return $this->belongsTo('Comment','oid','id')->field('id,oid,uid');
    }

}