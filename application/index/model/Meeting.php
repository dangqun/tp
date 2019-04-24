<?php


namespace app\index\model;

use think\Model;

/**
 * Class Meeting
 * @package app\index\model
 */
class Meeting extends Model
{
    //设置只读字段
    protected $readonly = ['name','email'];
}