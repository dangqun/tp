<?php


namespace app\index\validate;
/**
 * 会议类的验证
 */
use think\Validate;
class Meeting extends Validate
{

    protected $rule = [
        'host'=>'require|chsAlpha',//主持人
        'note_taker'=>'require|chsAlpha',//记录人
        'come_num'=>'require|number',//实到人数
        'should_num'=>'require|number',//应到人数
        'meeting_time'=>'require|date',//会议时间
        'address'=>'require',//会议详细地址
        'region'=>'require',//会议地区
        'content'=>'require',//会议内容
        'type'=>'require|number'//会议类型
    ];

    protected $message = [
        'host.require'=>'主持人必填',
        'host.chsAlpha'=>'主持人内容只能是汉字、字母',
        'note_taker.require'=>'记录人必填',
        'note_taker.chsAlpha'=>'记录人内容只能是汉字、字母',
        'come_num.require'=>'实到人数必选',
        'come_num.number'=>'实到人数内容只能是数字',
        'should_num.require'=>'应到人数必填',
        'should_num.number'=>'应到人数内容只能是数字',
        'meeting_time.require'=>'会议时间必填',
        'meeting_time.date'=>'会议时间格式错误',
        'address.require'=>'详细地址必填',
        'region.require'=>'会议地区必填',
        'content.require'=>'会议内容必填',
        'type.require'=>'会议类型必选',
    ];

    protected $scene = [

    ];

}