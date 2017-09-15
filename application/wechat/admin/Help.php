<?php

namespace app\wechat\admin;

use app\admin\controller\Admin;

/*
 * 模块帮助页
 */

class Help extends Admin
{
    public function index()
    {
        return $this->fetch();
    }

}