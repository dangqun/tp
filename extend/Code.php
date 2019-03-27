<?php
/**
 * 验证码
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 10:32
 */

trait Code
{

    protected $num = 4;//默认4位

    protected $timeOut = 600;//默认10分钟过期

    protected $codeMsg;

    /**
     * 生成验证码
     * @param $mobile
     * @return bool|int
     */
    protected function setCode($mobile){
        if(empty($mobile)){
            return false;
        }
        $min = str_pad(1,$this->num,"0",STR_PAD_RIGHT);
        $max = str_pad(9,$this->num,"9",STR_PAD_RIGHT);
        $code = rand($min,$max);
        $save = $this->save($mobile,$code);
        if($save == false){
            return false;
        }
        return $code;
    }

    /**
     * 验证
     * @param null $mobile
     * @param null $code
     * @param int $type
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkCode($mobile = null,$code = null,$type = 0){
        if($mobile == null || $code == null){
            return false;
        }
        $map = [];
        $map['mobile'] = $mobile;
        $map['type'] = empty($type) ? 0 : intval($type);
        $result = \think\Db::name('code')->where($map)->order('id DESC')->find();
        if(empty($result)){
            $this->codeMsg = '验证码错误!';
            return false;
        }
        if($result['overdue'] < NOW_TIME){
            $this->codeMsg = '验证码已过期';
            return false;
        }
        if($result['code'] != $code){
            $this->codeMsg = '验证码不正确';
            return false;
        }
        return true;
    }

    private function save($mobile,$code){
        $data = [];
        $data['mobile'] = $mobile;
        $data['code'] = $code;
        $data['overdue'] = NOW_TIME + $this->timeOut;
        $data['create_time'] = NOW_TIME;
        $result = \think\Db::name('code')->insert($data);
        return $result;
    }

    /**
     * @return int
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param int $num
     */
    public function setNum($num)
    {
        $this->num = $num;
    }

    /**
     * @return int
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @param int $timeOut
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $timeOut;
    }



}