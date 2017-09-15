<?php

namespace app\wxwall\model;

use think\Model as ThinkModel;
use think\Db;

class Order extends ThinkModel {

    // 设置当前模型对应的完整数据表名称
    protected $table = '__CMS_DOCUMENT__';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 获取订单列表
     * @param array $map 筛选条件
     * @param array $order 排序
     * @return mixed
     */
    public static function getList($map = [], $order = []) {
        $data_list = self::view('wxwall_order', true)
                ->view("admin_user", 'username', 'admin_user.id=wxwall_order.user_id', 'left')
                ->where($map)
                ->order($order)
                ->paginate();
        return $data_list;
    }

    /**
     * 获取单条订单
     * @param string $id 文档id
     * @param array $map 查询条件
     * @return mixed
     */
    public static function getOne($id = '', $map = []) {

        return Db::view('wxwall_order', true)
                        ->view("admin_user", 'username', 'admin_user.id=wxwall_order.user_id', 'left')
                        ->where('wxwall_order.id', $id)
                        ->where($map)
                        ->find();
    }
    
    public static function saveData(){
        
    }

}
