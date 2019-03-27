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

}