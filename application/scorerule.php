<?php


/**
 * 党群考评规则
 * Created by PhpStorm.
 * User: bin
 * Date: 2019/3/26
 * Time: 20:12
 */
return [
    'add'=>[//加分项
        'meeting'=>[
            'once'=>3,//一次3分
            'limit'=>36,//上限36分
            'type'=>1,
            'year'=>false//是否年终一次结算
        ],//党员会议
        'daily_activities'=>[
            'once'=>1,//一次1分
            'limit'=>12,//上限12分
            'year'=>false//是否年终一次结算
        ],//日常活动
        'promise'=>[
            'once'=>1,
            'limit'=>12,
            'year'=>true
        ],//不信教承诺书
        'activity'=>[
            'once'=>5,
            'limit'=>20,
            'year'=>false
        ],//志愿服务
        'red_cell'=>[
            'once'=>1.25,
            'limit'=>15,
            'year'=>false
        ],//红色细胞
        'tiny_wish'=>[
            'once'=>1,
            'limit'=>10,
            'year'=>false
        ],//微心愿
        'contribution'=>[
            'once'=>10,
            'limit'=>40,
            'year'=>false
        ],//献计献策
        'perform'=>[
            'once'=>8,
            'limit'=>8,
            'year'=>false
        ],//履行践诺
        'parent'=>[
            'pei_he_gong_zuo'=>[
                'once'=>6,
                'limit'=>12,
                'year'=>false
            ],//配合中心工作
            'social_welfare'=>[
                'once'=>10,
                'limit'=>40,
                'year'=>false
            ],//社会工作
            'liu_dong_dang_yuan_action_record'=>[
                'once'=>3,
                'limit'=>36,
                'year'=>false
            ],//流动党员活动记录
            'liu_dong_dang_yuan_fan_xiang'=>[
                'once'=>20,
                'limit'=>40,
                'year'=>false
            ],//流动党员反乡报道
            'social_responsibility'=>[
                'once'=>12,
                'limit'=>12,
                'year'=>true
            ],//社会责任
        ],//上级赋分赋分，实在不知道英语怎么翻译这个
    ],



    //减分项
    'reduce'=>[
        'late_leave_early'=>[
            'once'=>3,
            'limit'=>0,//0表示无上限
            'year'=>false
        ],
        'unpaid'=>[
            'once'=>1,
            'limit'=>0,
            'year'=>false
        ],
        'promise'=>[
            'once'=>10,
            'limit'=>0,
            'year'=>false
        ],
        'pei_he_gong_zuo'=>[
            'once'=>5,
            'limit'=>5,
            'year'=>true
        ],
        'gangs'=>[
            'once'=>10,
            'limit'=>10,
            'year'=>true
        ]
    ]

];