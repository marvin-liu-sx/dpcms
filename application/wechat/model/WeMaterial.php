<?php

namespace app\wechat\model;

use think\Model;

/*
 * 素材管理模型
 */

class WeMaterial extends Model
{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    public function getTypeTextAttr($value, $data)
    {
        $type = ['image' => '图片素材', 'voice' => '声音素材', 'video' => '视频素材', 'article' => '图文(文章)素材', 'news' => '图文(外链)素材'];
        if ($data['type'] == 'image') {
            $type['image'] = '<a class="img-link" href="' . $data['url'] . '"
                    data-toggle="tooltip"
                    rel="noreferrer"
                    title="点击查看大图"
                    target="_blank">图片素材</a>';
        }
        return $type[$data['type']];
    }

    public function getMediaIdTextAttr($value, $data)
    {
        if ($data['type'] == 'news') {
            return '此类型无没有MEDIA_ID';
        } else {
            return $data['media_id'];
        }
    }

}