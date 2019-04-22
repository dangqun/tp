<?php
namespace app\index\controller;
/**
 * 排行榜
 */

class Rankings extends Base
{

    public function index(){
        return $this->fetch('scoreranking');
    }

}