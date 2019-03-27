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

    /**
     * 生成验证码
     */
    protected function setCode(){
        $min = str_pad(1,$this->num,"0",STR_PAD_RIGHT);
        $max = str_pad(9,$this->num,"9",STR_PAD_RIGHT);
        $code = rand($min,$max);
        return $code;
    }

    /**
     * 验证
     */
    public function check($code){
        
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