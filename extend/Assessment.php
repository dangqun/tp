<?php

/**
 * 党员考核分计算
 * Trait Assessment
 */
use think\Db;
trait Assessment
{

    public $uid;

    public $score;

    public $type;

    public $typeStr;

    public $parent = false;

    protected $rule;


    public function add(){
        if(!$this->check()){
            return '参数错误';
        }
        $this->rule();
        $data = [];
        $data['uid'] = $this->uid;
        $data['create_time'] = NOW_TIME;
        $data['score'] = $this->rule['add'][$this->typeStr]['once'];
        $this->score = $data['score'];
        $map = [];
        $map['uid'] = $this->uid;
        if(!empty($this->type)){
            $data['type'] = $this->type;
            $map['type'] = $this->type;
        }
        if(!empty($this->typeStr)){
            $data['type_str'] = $this->typeStr;
            $map['type_str'] = $this->typeStr;
        }
        $map['del'] = 0;
        $map['create_time'] = [
            'BETWEEN',[
                getYearStartTime(),getYearEndTime()
            ]
        ];
        $is = Db::name('score')->where($map)->sum('score');
        if(!empty($is)){
            if($is >= $this->rule['add'][$this->typeStr]['limit']){
                return '积分达到上限';
            }
            $surplusScore = $this->rule['add'][$this->typeStr]['once'] - $is;//剩余可增加积分数
            if($surplusScore < $this->score){
                $data['score'] = $this->score - $surplusScore;
            }
        }
        $result = Db::name('score')->insert($data);
        if(empty($result)){
            return false;
        }
        return true;
    }


    public function reduce(){
        if(!$this->check()){
            return '参数错误';
        }
        return false;
    }

    protected function rule(){
        $this->rule = require_once (APP_PATH.DS.'scorerule.php');//引入积分规则文件
    }

    /**
     * 验证
     */
    protected function check(){
        if($this->uid == null){
            return false;
        }
        if($this->type == null && $this->typeStr == null){
            return false;
        }
        return true;
    }
}