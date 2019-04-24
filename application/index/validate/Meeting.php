<?php


namespace app\index\validate;
/**
 * 会议类的验证
 */
use think\Validate;
class Meeting
{

    protected $rule = [
        'host'=>'require',//主持人
        'note_taker'=>'require',//记录人
        'come_num'=>'require',//实到人数
        'should_num'=>'require',//应到人数
        'meeting_time'=>'require',//会议时间
        'address'=>'require',//会议详细地址
        'region'=>'require',//会议地区
        'content'=>'require',//会议内容
    ];

    protected $message = [
        'host.require'=>'主持人必填',
        'note_taker.require'=>'记录人必填',
        'come_num.require'=>'实到人数必选',
        'should_num.require'=>'应到人数必填',
        'meeting_time.require'=>'会议时间必填',
        'address.require'=>'详细地址必填',
        'region.require'=>'会议地区必填',
        'content.require'=>'会议内容必填'
    ];

    protected $scene = [

    ];

}