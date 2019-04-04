<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function getImgUrl($img){
    if(empty($img)){
        return '';
    }
    $url = request()->domain(). '/public/'.$img;
    return $url;
}

//获取一天的开始时间
function getDayStartTime($time = 0){
    if(empty($time)){
        $time = NOW_TIME;
    }
    return strtotime(date('Y-m-d 00:00:00',$time));
}

//获取一天的结束时间
function getDayEndTime($time = 0){
    if(empty($time)){
        $time = NOW_TIME;
    }
    return strtotime(date('Y-m-d 23:59:59',$time));
}

//获取一年的开始时间
function getYearStartTime($year = 0){
    if(empty($year)){
        $year = date('Y');
    }
    return strtotime(date("{$year}-01-01"));
}

//获取一年的结束时间
function getYearEndTime($year = 0){
    if(empty($year)){
        $year = date('Y');
    }
    return strtotime(date("{$year}-12-31"));
}