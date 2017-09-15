<?php

namespace app\wechat\model;

use think\Model;

/*
 * 自动回复管理模型
 */

class WeReply extends Model
{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    public function getTypeTextAttr($value, $data)
    {
        $type = ['text' => '文字内容', 'image' => '图片素材', 'voice' => '声音素材', 'video' => '视频素材', 'thumb' => '缩略图素材', 'article' => '图文(文章)素材', 'news' => '图文(外链)素材'];
        return $type[$data['type']];
    }

    public function getMsgTypeTextAttr($value, $data)
    {
        $type = ['text' => '回复关键词', 'image' => '回复图片', 'voice' => '回复语音', 'video' => '回复视频', 'location' => '回复位置', 'subscribe' => '关注事件', 'location_event' => '上报位置事件', 'click' => '点击自定义菜单事件'];
        return $type[$data['msg_type']];
    }

    // 关键词超长就裁剪
    public function getKeywordCutAttr($value, $data)
    {
        return string_cut($data['keyword'], 15);
    }

    public function getContentLinkAttr($value, $data)
    {
        if (is_numeric($data['content'])) {
            return '<a href="' . url('wechat/material/index', 'search_field=id&keyword=' . $data['content']) . '"
                    rel="noreferrer"
                    target="_blank">素材ID：' . $data['content'] . '</a>';
        } else {
            return string_cut($data['content'], 15);
        }
    }

    // 把有效期改为Unix时间戳
    public function setExpiresDateAttr($value)
    {
        return strtotime($value);
    }

    // 获取有效期
    public function getExpiresDateAttr($value)
    {
        return date('Y-m-d', $value);
    }

    // 获取彩色的有效期
    public function getExpiresDateColorAttr($value, $data)
    {
        if ($data['expires_date'] < time()) {
            return '<span class="font-w600 text-danger" style="text-decoration: line-through; ">' . date('Y-m-d', $data['expires_date']) . '</span>';
        } else {
            return '<span class="font-w600 text-success">' . date('Y-m-d', $data['expires_date']) . '</span>';
        }
    }
}