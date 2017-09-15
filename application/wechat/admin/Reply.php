<?php

namespace app\wechat\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\wechat\model\WeReply as WeReplyModel;
use app\wechat\model\WeMaterial as WeMaterialModel;

/*
 * 自动回复管理
 */

class Reply extends Admin
{
    use \app\wechat\Base;

    // 列表
    public function index()
    {
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        // 获取查询条件
        $map = $this->getMap();

        // 数据列表
        $data_list = WeReplyModel::where($map)->order('id desc')->paginate();

        // 分页数据
        $page = $data_list->render();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('自动回复列表')// 设置页面标题
            ->setTableName('WeReply')// 设置数据表名
            ->setSearch(['id' => 'ID', 'keyword' => '关键词', 'content' => '回复内容'])// 设置搜索参数
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['msg_type_text', '触发方式'],
                ['keyword_cut', '触发关键词'],
                ['type_text', '回复类型'],
                ['content_link', '回复内容'],
                ['expires_date_color', '有效期'],
                ['create_time', '创建日期', 'datetime'],
                ['status', '状态', 'switch'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,enable,disable,delete')// 批量添加顶部按钮
            ->addRightButtons('edit,delete')// 批量添加右侧按钮
            ->setRowList($data_list)// 设置表格数据
            ->setPages($page)// 设置分页数据
            ->fetch(); // 渲染页面
    }

    // 添加自动回复
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'WeReply');
            if ($result === true && $data['type'] != 'text') {
                if (is_numeric($data['content']) && $data['content'] > 0) {
                    $we_material = WeMaterialModel::get($data['content']);
                    if ($we_material && $we_material['type'] == $data['type']) {
                        $result = true;
                    } else {
                        $result = '回复内容指定的素材ID不存在或者对应的类型错误';
                    }
                } else {
                    $result = '回复内容类型应为素材ID';
                }
            }
            // 验证失败 输出错误信息
            if (true !== $result) return $this->error($result);

            if ($user = WeReplyModel::create($data)) {
                return $this->success('添加成功', cookie('__forward__'));
            } else {
                return $this->error('添加失败');
            }
        }

        $default_expires_date = date('Y-m-d', strtotime('+30 day', time()));    // 默认有效期为30天之后

        return ZBuilder::make('form')
            ->setPageTitle('添加关键词')// 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['select', 'msg_type', '触发方式', '用户以什么方式触发自动回复', ['text' => '回复关键词', 'image' => '回复图片', 'voice' => '回复语音', 'video' => '回复视频', 'location' => '回复位置', 'subscribe' => '关注事件', 'location_event' => '上报位置事件', 'click' => '点击自定义菜单事件'], 'text'],
                ['text', 'keyword', '关键词'],
                ['radio', 'mode', '匹配模式', '', ['模糊搜索', '完整匹配'], 1],
                ['select', 'type', '回复类型', '', ['text' => '文字内容', 'image' => '图片素材', 'voice' => '声音素材', 'video' => '视频素材', 'article' => '图文(文章)素材', 'news' => '图文(外链)素材'], 'text'],
                ['textarea', 'content', '回复内容', '若回复纯文字，直接填写内容；其他类型填写素材管理列表中的数字ID'],
                ['date', 'expires_date', '有效期', '默认有效期为30天之后。小于或等于当前日期 <code>' . date('Y-m-d') . '</code> 则表示过期', $default_expires_date, 'yyyy-mm-dd'],
                ['radio', 'status', '状态', '', ['禁用', '启用'], 1],
            ])
            ->setTrigger('msg_type', 'text', 'keyword,mode')
            ->fetch();
    }

    // 编辑
    public function edit($id = null)
    {
        if ($id === null) return $this->error('缺少参数');

        // 保存数据
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'WeReply');
            if ($result === true && $data['type'] != 'text') {
                if (is_numeric($data['content']) && $data['content'] > 0) {
                    $we_material = WeMaterialModel::get($data['content']);
                    if ($we_material && $we_material['type'] == $data['type']) {
                        $result = true;
                    } else {
                        $result = '回复内容指定的素材ID不存在或者对应的类型错误';
                    }
                } else {
                    $result = '回复内容类型应为素材ID';
                }
            }
            // 验证失败 输出错误信息
            if (true !== $result) return $this->error($result);

            if (WeReplyModel::update($data)) {
                return $this->success('编辑成功', cookie('__forward__'));
            } else {
                return $this->error('编辑失败');
            }
        }

        // 获取数据
        $we_reply_info = WeReplyModel::get($id);
        if (!$we_reply_info) {
            return $this->error('内容不存在');
        }

        $default_expires_date = date('Y-m-d', strtotime('+30 day', time()));    // 默认有效期为30天之后

        return ZBuilder::make('form')
            ->setPageTitle('编辑关键词')// 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['hidden', 'id'],
                ['select', 'msg_type', '触发方式', '用户以什么方式触发自动回复', ['text' => '回复关键词', 'image' => '回复图片', 'voice' => '回复语音', 'video' => '回复视频', 'location' => '回复位置', 'subscribe' => '关注事件', 'location_event' => '上报位置事件', 'click' => '点击自定义菜单事件'], 'text'],
                ['text', 'keyword', '关键词'],
                ['radio', 'mode', '匹配模式', '', ['模糊搜索', '完整匹配'], 1],
                ['select', 'type', '回复类型', '', ['text' => '文字内容', 'image' => '图片素材', 'voice' => '声音素材', 'video' => '视频素材', 'article' => '图文(文章)素材', 'news' => '图文(外链)素材'], 'text'],
                ['textarea', 'content', '回复内容', '若回复纯文字，直接填写内容；其他类型填写素材管理列表中的数字ID'],
                ['date', 'expires_date', '有效期', '小于或等于当前日期 <code>' . date('Y-m-d') . '</code> 则表示过期', $default_expires_date, 'yyyy-mm-dd'],
                ['radio', 'status', '状态', '', ['禁用', '启用'], 1],
            ])
            ->setTrigger('msg_type', 'text', 'keyword,mode')
            ->setFormData($we_reply_info)// 设置表单数据
            ->fetch();
    }
}