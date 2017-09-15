<?php

namespace app\wechat\home;

use think\Db;
use EasyWeChat\Message\Text;    // 文本消息

/*
 * 处理接收到的除事件消息
 * 方法名全部小写
 */

class Event extends AutoReply
{
    protected $message;
    protected $app;

    public function __construct($message, $app)
    {
        $this->message = $message;
        $this->app = $app;
    }

    // 关注
    public function subscribe()
    {
        $data = $this->needAutoReply('subscribe');
        if ($data) { // 设置了自动回复
            $res = $this->reply($data, $this->app);
            if ($res !== false) {
                return $res;
            }
        }

        // 没设自动回复就执行下面代码
        $text = new Text();
        $text->content = '感谢关注本微信号，我们已经等你多时了！';    // 文本内容
        return $text;
    }

    // 取消关注
    public function unsubscribe()
    {
        trace('用户' . $this->message->FromUserName . '已取消关注了本微信', 'info');
    }

    // 上报地理位置事件
    // 用户同意上报地理位置后，每次进入公众号会话时，都会在进入时上报地理位置，或在进入会话后每5秒上报一次地理位置，公众号可以在公众平台网站中修改以上设置。上报地理位置时，微信会将上报地理位置事件推送到开发者填写的URL。
    public function location()
    {
        $data = $this->needAutoReply('location_event');
        if ($data) { // 设置了自动回复
            $res = $this->reply($data, $this->app);
            if ($res !== false) {
                return $res;
            }
        }

        // 没设自动回复就执行下面代码
        $text = new Text();
        $text->content = '我们已收到您上报的地理位置事件 纬度: ' . $this->message->Latitude . ' 经度: ' . $this->message->Longitude;    // 文本内容
        return $text;


    }

    // 点击自定义菜单事件
    public function click()
    {
        $data = $this->needAutoReply('click');
        if ($data) { // 设置了自动回复
            $res = $this->reply($data, $this->app);
            if ($res !== false) {
                return $res;
            }
        }

        // 没设自动回复就执行下面代码
        $text = new Text();
        $text->content = '用户点击了自定义菜单: ' . $this->message->EventKey;    // 文本内容
        return $text;
    }
}