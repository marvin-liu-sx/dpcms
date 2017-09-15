<?php

namespace app\wechat\validate;

use think\Validate;

/*
 * 素材管理验证器
 */

class WeMaterial extends Validate
{
    // 定义验证规则
    protected $rule = [
        'name|素材名' => 'require',
        'type|素材类型' => 'require|in:image,voice,video,thumb,article,news',

        // 图片
        'image_file' => 'requireIf:type,image',
        // 声音
        'voice_file' => 'requireIf:type,voice',
        // 视频
        'video_file' => 'requireIf:type,video',
        'video_title' => 'requireIf:type,video',
        // 图文
        'news_title' => 'requireIf:type,news',
        'news_description' => 'requireIf:type,news',
        'news_url' => 'requireIf:type,news',
        // 文章
        'article_title' => 'requireIf:type,article',
        'article_author' => 'requireIf:type,article',
        'article_digest' => 'requireIf:type,article',
        'article_content' => 'requireIf:type,article',
        'article_cover_pic' => 'requireIf:type,article',

    ];

    // 定义验证提示
    protected $message = [
        'name.require' => '素材名不能为空',
        'type.require' => '素材类型不能为空',
        'type.in' => '素材类型不存在',

        'image_file.requireIf' => '请先上传图片文件',

        'voice_file.requireIf' => '请先上传声音文件',

        'video_file.requireIf' => '请先上传视频文件',
        'video_title.requireIf' => '请填写视频标题',

        'article_title.requireIf' => '请填写图文标题',
        'article_author.requireIf' => '请填写图文作者',
        'article_digest.requireIf' => '请填写图文摘要',
        'article_content.requireIf' => '请填写图文内容',
        'article_cover_pic.requireIf' => '请先上传图文封面',
    ];

    // 定义验证场景
    protected $scene = [
        'edit' => ['name', 'type' => 'in:article,news', 'article_title', 'article_author', 'article_digest', 'article_content', 'article_cover_pic', 'news_title', 'news_description', 'news_url'],
    ];

}