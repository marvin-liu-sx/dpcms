<?php

namespace app\wechat\admin;

use app\admin\controller\Admin;

/*
 * 微信配置
 */

class Config extends Admin
{
    public function index()
    {
        return $this->moduleConfig();
    }
}