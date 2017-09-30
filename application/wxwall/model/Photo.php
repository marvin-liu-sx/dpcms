<?php

namespace app\wxwall\model;

use think\Model as ThinkModel;
use think\Db;

class Photo extends ThinkModel {

    // 设置当前模型对应的完整数据表名称
    protected $table = '__WXWALL_PHOTO__';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    
    /**
     * 获取列表
     * @param type $map
     * @param type $order
     * @return type
     */
    public static function getList($map = [], $order = []) {
        $data_list = self::view('wxwall_photo', true)
                ->view("admin_user", 'username', 'admin_user.id=wxwall_photo.user_id', 'left')
                ->view("wxwall_order", 'order_number', 'wxwall_order.order_number=wxwall_photo.order_id', 'left')
                ->where($map)
                ->order($order)
                ->paginate();
        return $data_list;
    }

    /**
     * 获取单条数据
     * @param string $id 视频id
     * @param array $map 查询条件
     * @return mixed
     */
    public static function getOne($id = '', $map = []) {

        return Db::view('wxwall_photo', true)
                        ->view("admin_user", 'username', 'admin_user.id=wxwall_photo.user_id', 'left')
                        ->view("wxwall_order", 'order_number', 'wxwall_order.order_number=wxwall_photo.order_id', 'left')
                        ->where('wxwall_photo.id', $id)
                        ->where($map)
                        ->find();
    }

}
