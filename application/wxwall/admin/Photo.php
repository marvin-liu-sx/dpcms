<?php

namespace app\wxwall\admin;

use app\admin\controller\Admin;
use app\wxwall\model\Photo as PhotoModel;
use app\common\builder\ZBuilder;
use think\Db;

class Photo extends Admin{
    public function index(){
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        // 查询
        $map = $this->getMap();
        // 排序
        $order = $this->getOrder('id desc');
        // 数据列表
        $data_list = PhotoModel::getList($map, $order);
        return ZBuilder::make('table')
                        ->setPageTitle('照片管理')
                        ->setSearch(['name'=>'照片名称','order_number' => '订单号', 'username' => '用户昵称']) // 设置搜索框
                        ->addColumns([ // 批量添加数据列
                            ['id', 'ID'],
                            ['name', '照片名称'],
                            ['path', '保存路径'],
                            ['username', '用户昵称'],
                            ['order_number', '订单号'],
                            ['size', '照片大小'],
                            ['type', '照片类型'],
                            ['create_time', '上传时间', 'datetime'],
                        ])
                        ->addTopButtons('enable,disable,delete') // 批量添加顶部按钮
                        ->addOrder(['column_name' => 'cms_document.cid'])
                        ->addOrder('id,title,view,username,update_time')
                        ->addFilter(['column_name' => 'cms_column.name', 'username' => 'admin_user'])
                        ->setRowList($data_list) // 设置表格数据
                        ->fetch(); // 渲染模板
    }
}