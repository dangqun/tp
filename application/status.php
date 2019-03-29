<?php
/**
 * 状态码提示数组
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 20:12
 */
return [
    //普通
    '200'=>'请求成功！',
    '400'=>'请求失败！请稍后重试',
    '401'=>'服务繁忙,请稍后重试！',

    //接口
    '3001'=>'没有更多数据了',
    '3002'=>'参数错误！',

    //登录
    '1000'=>'登录成功！',
    '1001'=>'账号不存在!',
    '1002'=>'密码错误',
    '1003'=>'账号已注册',
    '1004'=>'已登录',
    '1005'=>'请先登录',


    //数据验证
    '4001'=>'数据验证失败！',

    //上传
    '2001'=>'上传失败',
    '2002'=>'上传信息错误',
    '2000'=>'上传成功',

    //活动
    '5001'=>'你还不在组织内！',
    '5002'=>'发布失败,稍后重试！',
    '5003'=>'收藏失败,请稍后重试！',
    '5006'=>'取消收藏失败,请稍后重试！',
    '5004'=>'已收藏，不要重复收藏',
    '5005'=>'你没有收藏，无需取消',

    //组织
    '6001'=>'组织参数错误',

    //报警
    '10001'=>'你发布活动太频繁了，等一会再发布吧！',
];