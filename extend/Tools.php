<?php

/**
 * 工具类
 * Class Tools
 */
use think\Db;
use think\Request;
class Tools
{
    /**
     * 上传内容
     * @param Request $request
     * @return bool
     */
    static function upload(Request $request){
        if($request->file('')){

        }
    }

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
     * 修改积分
     * @param $uid 要修改的用户
     * @param $score 修改的积分值
     * @param int $type 1：增加，2：减少
     */
    static function score($uid,$score,$type = 1){

    }

    /**
     * 上传图片
     * @param array $data
     */
    private function uploadImg(Request $request){

    }

    /**
     * 上传base64图片
     * @param array $data
     */
    private function uploadImgBase64(Request $request){

    }

}