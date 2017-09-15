<?php

namespace app\wxwall\admin;

use app\admin\controller\Admin;
use app\wxwall\model\Order as OrderModel;
use app\common\builder\ZBuilder;
use think\Db;

/**
 * 微信墙订单管理
 */
class Order extends Admin {

    public function index() {
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        // 查询
        $map = $this->getMap();
        // 排序
        $order = $this->getOrder('id desc');
        // 数据列表
        $data_list = OrderModel::getList($map, $order);
        return ZBuilder::make('table')
                        ->setPageTitle('订单管理')
                        ->setSearch(['order_number' => '订单号', 'username' => '用户昵称']) // 设置搜索框
                        ->addColumns([ // 批量添加数据列
                            ['id', 'ID'],
                            ['groom', '新郎姓名'],
                            ['bride', '新娘姓名'],
                            ['package_price', '订单总价'],
                            ['username', '用户昵称'],
                            ['order_number', '订单号'],
                            ['wedding_date', '婚礼时间', 'datetime'],
                            ['create_time', '下单时间', 'datetime'],
                            ['pay_status', '状态', 'switch'],
                            ['right_button', '操作', 'btn']
                        ])
                        ->addTopButtons('enable,disable,delete') // 批量添加顶部按钮
                        ->addRightButtons(['edit', 'delete']) // 批量添加右侧按钮
                        ->addOrder(['column_name' => 'cms_document.cid'])
                        ->addOrder('id,title,view,username,update_time')
                        ->addFilter(['column_name' => 'cms_column.name', 'username' => 'admin_user'])
                        ->setRowList($data_list) // 设置表格数据
                        ->fetch(); // 渲染模板
    }

}
