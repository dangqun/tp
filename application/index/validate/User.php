<?php
/**
 * 用户验证类
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 21:54
 */

namespace app\index\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'name'=>'require|max:25',
        'email'=>'require|email',
        'password'=>'require|length:8,12|confirm:repassword',
        'repassword'=>'require|confirm:password',
        'mobile'=>'require|length:11|regex:mobile',
        'token'=>'token'
    ];

    protected $message = [
        'name.require'=>'名称必填',
        'name.max'=>'名称最多不能超过25个字符',
        'email.require'=>'邮箱必填',
        'email.email'=>'邮箱格式错误',
        'password.require'=>'密码必填',
        'password.length'=>'密码长度必须为8-12字符',
        'password.confirm'=>'密码和确认密码不一致',
        'repassword.require'=>'确认密码必填',
        'mobile.require'=>'手机号码必填',
        'mobile.length'=>'手机号码必须为11位',
        'mobile.regex'=>'手机号码格式不正确',
        'token.token'=>'令牌验证失败',
    ];

    /**
     * 验证场景
     * @var array
     */
    protected $scene = [
        'edit'=>[
            'name','password','token'
        ],//edit只验证name和age
        'register'=>[
            'mobile','password','repassword'
        ],
        'login'=>[
            'mobile','password','repssword','token'
        ],
        'code'=>[
            'mobile'
        ]
    ];

    /**
     * 正则验证
     * @var array
     */
    protected $regex = [
        'mobile'=>'/^1[34578]\d{9}$/'
    ];
}