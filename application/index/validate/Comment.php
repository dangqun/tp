<?php
/**
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/28
 * Time: 13:30
 */

namespace app\index\validate;


use think\Validate;

class Comment extends Validate
{

    protected $rule = [
        'content'=>'require|max:255',
    ];

    protected $message = [
        'content.require'=>'评论内容必填',
        'content.max'=>'评论内容最长255个字符'
    ];

}