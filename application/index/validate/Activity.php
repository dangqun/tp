<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/27
 * Time: 22:07
 */

namespace app\index\validate;


use think\Validate;

class Activity extends Validate
{
    protected $rule = [
        'title'=>'require',
        'img'=>'require',
        'type'=>'require',
        'address'=>'require',
        'start_time'=>'require',
        'end_time'=>'require',
        'content'=>'require',
        'details'=>'require',
    ];

    protected $message = [
        'title.require'=>'标题必填',
        'img.require'=>'图片必填',
        'type.require'=>'类型必选',
        'address.require'=>'地址必填',
        'start_time.require'=>'开始时间必填',
        'end_time.require'=>'结束时间必填',
        'content.require'=>'活动内容必填',
        'details.require'=>'活动详情必填'
    ];

    protected $scene = [

    ];

}