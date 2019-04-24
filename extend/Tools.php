<?php

/**
 * 工具类
 * Class Tools
 */
use think\Db;
class Tools
{

    /**
     * 收藏
     * @param $obj_id
     * @param $uid
     * @param int $type
     * @return bool|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    static function collection($obj_id,$uid,$type = 1){
        if($obj_id == null || $uid == null){
            return false;
        }
        $map = [
            'obj_id'=>$obj_id,
            'uid'=>$uid,
            'type'=>$type,
            'del'=>0
        ];
        $is = Db::name('collection')->where($map)->find();
        if(!empty($is)){
            return -1;
        }
        $data = [
            'obj_id'=>$obj_id,
            'uid'=>$uid,
            'type'=>$type,
            'create_time'=>NOW_TIME
        ];
        $result = Db::name('collection')->insert($data);
        return $result;
    }

    /**
     * 取消收藏
     * @param $obj_id
     * @param $uid
     * @param int $type
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    static function cancelCollection($obj_id,$uid,$type = 1){
        if($obj_id == null || $uid == null){
            return false;
        }
        $map = [
            'obj_id'=>$obj_id,
            'uid'=>$uid,
            'type'=>$type,
            'del'=>0
        ];
        $is = Db::name('collection')->where($map)->find();
        if(!empty($is)){
            return -1;
        }
        $data = [
            'del'=>NOW_TIME
        ];
        $result = Db::name('collection')->where('id',$is['id'])->update($data);
        return $result;
    }

    /**
     * 关注
     * @param $obj_id
     * @param $uid
     * @param int $type
     * @return bool|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    static function follow($obj_id,$uid,$type = 1){
        if($obj_id == null || $uid == null){
            return false;
        }
        $map = [
            'obj_id'=>$obj_id,
            'uid'=>$uid,
            'type'=>$type,
            'del'=>0
        ];
        $is = Db::name('follow')->where($map)->find();
        if(!empty($is)){
            return -1;
        }
        $data = [
            'obj_id'=>$obj_id,
            'uid'=>$uid,
            'type'=>$type,
            'create_time'=>NOW_TIME
        ];
        $result = Db::name('follow')->insert($data);
        return $result;
    }

    /**
     * 取消关注
     * @param $obj_id
     * @param $uid
     * @param int $type
     * @return bool|int|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    static function cancelFollow($obj_id,$uid,$type = 1){
        if($obj_id == null || $uid == null){
            return false;
        }
        $map = [
            'obj_id'=>$obj_id,
            'uid'=>$uid,
            'type'=>$type,
            'del'=>0
        ];
        $is = Db::name('follow')->where($map)->find();
        if(!empty($is)){
            return -1;
        }
        $data = [
            'del'=>NOW_TIME
        ];
        $result = Db::name('follow')->where('id',$is['id'])->update($data);
        return $result;
    }

    /**
     * 修改积分
     * @param $uid 要修改的用户
     * @param $score 修改的积分值
     * @param int $type 1：增加，2：减少
     */
    static function score($uid,$score,$type = 1){

    }

}