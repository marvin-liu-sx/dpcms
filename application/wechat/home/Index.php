<?php

namespace app\wechat\home;

use app\index\controller\Home;
use think\Db;

/*
 * 微信服务器访问的入口，不要用浏览器访问
 */

class Index extends Home
{
    use \app\wechat\Base;

    public function index()
    {
        $this->app->server->setMessageHandler(function ($message) {
            if ($message->MsgType == 'event') {
                $class = '\\app\\wechat\\home\\Event';
                return call_user_func([new $class($message, $this->app), strtolower($message->Event)]);
            } else {
                $class = '\\app\\wechat\\home\\Message';
                return call_user_func([new $class($message, $this->app), strtolower($message->MsgType)]);
            }

        });
        $this->app->server->serve()->send();
    }
}