<?php

namespace app\wechat\validate;

use think\Validate;

/*
 * 自动回复管理验证器
 */

class WeReply extends Validate
{
    // 定义验证规则
    protected $rule = [
        'keyword' => 'requireIf:msg_type,text',
        'type' => 'require|in:text,image,voice,video,article,news',
        'msg_type' => 'require|in:text,image,voice,video,subscribe,location,click',
        'content' => 'require',
    ];

    // 定义验证提示
    protected $message = [
        'keyword.requireIf' => '关键词不能为空',
        'type.require' => '回复类型不能为空',
        'type.in' => '回复类型不存在',
        'content.require' => '回复内容不能为空',
    ];
}