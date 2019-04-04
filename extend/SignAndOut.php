<?php

use think\exception\DbException;
use think\Loader;
use think\Db;
/**
 * 签到签退
 * Trait Sign
 */
trait SignAndOut
{
    use Assessment;

    /**
     * 签到
     * @param $id
     * @param int $lng
     * @param int $lat
     * @throws DbException
     * @throws \think\exception\PDOException
     * @throws \think\Exception
     */
    public function sign($id,$lng = 0,$lat = 0){
        if(empty($id)){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $info = $this->validateActivity($id);
        if(!$info instanceof \app\index\model\Activity){
            return;
        }
        $range = $this->distance($lat,$lng,$info->lat,$info->lng);
        if($range > $info->range){
            $this->result['error_code'] =  5014;
            $this->output();
            return;
        }
        $map = [
            'uid'=>$this->userInfo['id'],
            'create_time'=>[
                'BETWEEN',[
                    getDayStartTime(),getDayEndTime()
                ]
            ]
        ];
        try{
            $is = Db::name('activity_sign')->where($map)->count('id');
        }catch(DbException $e){
            $this->result['error_code'] = 10000;
            $this->output();
            return;
        }
        if($is == 3){
            $this->result['error_code'] = 5018;
            $this->output();
            return;
        }
        $map['aid'] = $id;
        try{
            $is = Db::name('activity_sign')->where($map)->order('id DESC')->find();
        }catch(DbException $e){
            $this->result['error_code'] = 10000;
            $this->output();
            return;
        }
        if(!empty($is) && $is['status'] == 1){
            $this->result['error_code'] = 5015;
            $this->output();
            return;
        }
        $data = [];
        $data['uid'] = $this->userInfo['id'];
        $data['aid'] = $id;
        $data['sign'] = NOW_TIME;
        $data['create_time'] = NOW_TIME;
        $data['status'] = 1;
        $info->startTrans();
        try{
            $result = Db::name('activity_sign')->insert($data);
        }catch(DbException $e){
            $this->result['error_code'] = 10000;
            $this->output();
            return;
        }
        if(empty($result)){
            $info->rollback();
            $this->result['error_code'] = 400;
            $this->output();
            return;
        }
        $info->commit();
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 签退
     * @param $id
     * @param int $lng
     * @param int $lat
     * @throws \think\exception\PDOException
     */
    public function signOut($id,$lng = 0,$lat = 0){
        if(empty($id)){
            $this->result['error_code'] = 3002;
            $this->output();
            return;
        }
        $info = $this->validateActivity($id);
        if(!$info instanceof \app\index\model\Activity){
            return;
        }
        $range = $this->distance($lat,$lng,$info->lat,$info->lng);
        if($range > $info->range){
            $this->result['error_code'] =  5014;
            $this->output();
            return;
        }
        $map = [
            'aid'=>$id,
            'uid'=>$this->userInfo['id']
        ];
        try{
            $is = Db::name('activity_sign')->where($map)->order('id DESC')->find();
        }catch(DbException $e){
            $this->result['error_code'] = 10000;
            $this->output();
            return;
        }
        if(empty($is)){
            $this->result['error_code'] = 5019;
            $this->output();
            return;
        }
        if($is['status'] == 2){
            $this->result['error_code'] = 5017;
            $this->output();
            return;
        }
        $data = [];
        $data['sign_out'] = NOW_TIME;
        $data['status'] = 2;
        $info->startTrans();
        try{
            $result = Db::name('activity_sign')->where('id','=',$is['id'])->update($data);
        }catch(DbException $e){
            $this->result['error_code'] = 10000;
            $this->output();
            return;
        }
        if(empty($result)){
            $info->rollback();
            $this->result['error_code'] = 400;
            $this->output();
            return;
        }
        $result = $this->score();
        if($result == false){
            $this->result['error_code'] = 400;
            $this->output();
            $info->rollback();
            return;
        }
        $info->commit();
        $this->result['code'] = 200;
        $this->output();
    }

    /**
     * 活动验证
     * @param int $id
     * @return object
     */
    protected function validateActivity($id = 0){
        if(empty($id)){
            $this->output();
        }
        $model = Loader::model('Activity');
        $info = $model->find($id);
        if(empty($info)){
            $this->result['error_code'] = 5007;
            $this->output();
            return;
        }
        if($info->status != 1){
            $this->result['error_code'] = 5012;
            $this->output();
            return;
        }
        if($info->del == 1){
            $this->result['error_code'] = 5013;
            $this->output();
            return;
        }
        if($info->end_time < NOW_TIME){
            $this->result['error_code'] = 5016;
            $this->output();
            return;
        }
        return $info;
    }

    /**
     * 根据经纬度计算两点之间的距离-方法1
     * 单位千米
     * @param $lat1
     * @param $lng1
     * @param $lat2
     * @param $lng2
     * @return int
     */
    private function distance($lat1, $lng1, $lat2, $lng2) {
        //将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137;
        return $s;
    }

    /**
     * 党员计分
     */
    protected function score(){
        $this->typeStr = 'activity';
        $this->uid = $this->userInfo['id'];
        $result = $this->add();
        $data = [
            'uid'=>$this->userInfo['id'],
            'score'=>$this->score,
            'create_time'=>NOW_TIME
        ];
        if($result === true){
            $data['content'] = "用户{$this->userInfo['id']}成功签退增加了[{$this->score}]积分";
        }else if($result === false){
            $data['content'] = "用户{$this->userInfo['id']}成功签退但增加积分失败！";
        }else{
            $data['content'] = "用户{$this->userInfo['id']}成功签退但积分达到上限，没有增加积分！";
        }
        $result = Db::name('score_log')->insert($data);
        if(empty($result)){
            return false;
        }
        return true;
    }

}