<?php

namespace app\wechat\home;

use think\Db;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\Video;
use EasyWeChat\Message\Voice;
use EasyWeChat\Message\News;

/*
 * 组装自动回复内容
 */

class AutoReply
{
    /**
     * 回复
     * @param array $data we_reply表查出来的单条数据
     * @param object $app easywechat项目
     * @return object/false
     */
    protected function reply($data, $app)
    {
        switch ($data['type']) {
            case 'text':
                return new Text(['content' => $data['content']]);
                break;
            case 'image':
                if (is_numeric($data['content'])) {
                    $material = Db::name('we_material')->field(true)->where(['id' => $data['content'], 'type' => 'image'])->find();
                    if ($material) {
                        return new Image(['media_id' => $material['media_id']]);
                    }
                }
                break;
            case 'voice':
                if (is_numeric($data['content'])) {
                    $material = Db::name('we_material')->field(true)->where(['id' => $data['content'], 'type' => 'voice'])->find();
                    if ($material) {
                        return new Voice(['media_id' => $material['media_id']]);
                    }
                }
                break;
            case 'video':
                if (is_numeric($data['content'])) {
                    $material = Db::name('we_material')->field(true)->where(['id' => $data['content'], 'type' => 'video'])->find();
                    if ($material) {
                        $material_content = json_decode($material['content'], true);
                        return new Video([
                            'title' => $material_content['title'],
                            'media_id' => $material['media_id'],
                            'description' => $material_content['description'],
                        ]);
                    }
                }
                break;
            case 'article':
                if (is_numeric($data['content'])) {
                    $material = Db::name('we_material')->field(true)->where(['id' => $data['content']])->find();
                    if ($material) {
                        $news_material = $app->material->get($material['media_id']);
                        $news = new News();
                        $news->title = $news_material['news_item'][0]['title'];
                        $news->description = $news_material['news_item'][0]['digest'];
                        $news->url = $news_material['news_item'][0]['url'];
                        $news->image = $news_material['news_item'][0]['thumb_url'];
                        return $news;
                    }
                }
                break;
            case 'news':
                if (is_numeric($data['content'])) {
                    $material = Db::name('we_material')->field(true)->where(['id' => $data['content']])->find();
                    if ($material) {
                        $material_content = json_decode($material['content'], true);
                        $news = new News();
                        $news->title = $material_content['title'];
                        $news->description = $material_content['description'];
                        $news->url = $material_content['url'];
                        $news->image = request()->domain() . get_file_path($material_content['image']);
                        return $news;
                    }
                }
                break;
        }

        return false;
    }

    /**
     * 是否需要自动回复
     * @param string $msg_type 触发类型
     * @param object $app easywechat项目
     * @return array
     */
    protected function needAutoReply($msg_type)
    {
        return Db::name('we_reply')->where(['msg_type' => $msg_type, 'expires_date' => ['>', time()], 'status' => 1])->order('id desc')->find();

    }
}