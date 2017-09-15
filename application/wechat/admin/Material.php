<?php

namespace app\wechat\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\wechat\model\WeReply as WeReplyModel;
use app\wechat\model\WeMaterial as WeMaterialModel;
use EasyWeChat\Message\Article;

/*
 * 素材管理
 */

class Material extends Admin
{
    use \app\wechat\Base;

    // 永久素材列表
    public function index()
    {
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        // 获取查询条件
        $map = $this->getMap();

        // 数据列表
        $data_list = WeMaterialModel::where($map)->order('id desc')->paginate();

        // 分页数据
        $page = $data_list->render();

        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('永久素材列表')// 设置页面标题
            ->setTableName('WeMaterial')// 设置数据表名
            ->setSearch(['id' => 'ID', 'name' => '素材名', 'media_id' => 'MEDIA_ID'])// 设置搜索参数
            ->addColumns([ // 批量添加列
                ['id', 'ID'],
                ['name', '素材名'],
                ['type_text', '类型'],
                ['media_id_text', 'media_id'],
                ['create_time', '上传日期', 'datetime'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,delete')// 批量添加顶部按钮
            ->addRightButtons('edit,delete')// 批量添加右侧按钮
            ->setRowList($data_list)// 设置表格数据
            ->setPages($page)// 设置分页数据
            ->fetch(); // 渲染页面
    }

    // 上传素材
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            $post = $this->request->post();

            // 验证
            $result = $this->validate($post, 'WeMaterial');
            // 验证失败 输出错误信息
            if (true !== $result) return $this->error($result);

            // easywechat 要求绝对路径
            $root_path = $_SERVER['DOCUMENT_ROOT'];

            $data = [
                'media_id' => '',
                'name' => $post['name'],
                'type' => $post['type'],
            ];

            switch ($post['type']) {
                case 'image':
                    $result = $this->app->material->uploadImage($root_path . get_file_path($post['image_file']));
                    $data['media_id'] = $result->media_id;
                    $data['url'] = $result->url;
                    $data['attachment_id'] = $post['image_file'];
                    break;
                case 'voice':
                    $result = $this->app->material->uploadVoice($root_path . get_file_path($post['voice_file']));
                    $data['media_id'] = $result->media_id;
                    $data['attachment_id'] = $post['voice_file'];
                    break;
                case 'video':
                    $result = $this->app->material->uploadVideo($root_path . get_file_path($post['video_file']), $post['video_title'], $post['video_description']);
                    $data['media_id'] = $result->media_id;
                    $data['attachment_id'] = $post['video_file'];
                    $data['content'] = json_encode(['title' => $post['video_title'], 'description' => $post['video_description']]);
                    break;
                case 'news':    // 微信文档中被动回复里的“图文消息”
                    $news_data = [
                        'title' => $post['news_title'],
                        'description' => $post['news_description'],
                        'url' => $post['news_url'],
                        'image' => $post['news_image'],
                    ];
                    $data['media_id'] = ''; // 这种素材只记录在本地数据库，所以没有 media_id
                    $data['content'] = json_encode($news_data);
                    break;
                case 'article':// 上传单篇文章，这种素材实际是微信公众平台上的图文素材。但不是微信文档中被动回复里的“图文消息”
                    $result_thumb = $this->app->material->uploadThumb($root_path . get_file_path($post['article_cover_pic']));
                    $article_data = [
                        'title' => $post['article_title'],
                        'thumb_media_id' => $result_thumb->media_id,
                        'author' => $post['article_author'],
                        'digest' => $post['article_digest'],
                        'show_cover_pic' => isset($post['article_show_cover_pic']) ? 1 : 0,
                        'content_source_url' => $post['article_content_source_url'],
                        'content' => htmlspecialchars_decode($post['article_content'])
                    ];
                    $article = new Article($article_data);
                    $result_article = $this->app->material->uploadArticle($article);
                    $data['media_id'] = $result_article->media_id;
                    $data['attachment_id'] = $post['article_cover_pic'];
                    $data['content'] = json_encode($article_data);
                    break;
            }
            if ($data['media_id'] || $post['type'] == 'news') {
                if (WeMaterialModel::create($data)) {
                    return $this->success('发布成功', cookie('__forward__'));
                } else {
                    return $this->error('本地数据写入失败');
                }
            } else {
                return $this->error('上传微信平台失败');
            }
        }

        // 使用ZBuilder快速创建表单
        $ajax_url = url('wechat/material/uploadArticleImage', [], '');
        $upload_article_image_js = <<<EOF
            <script type="text/javascript">
                $(function(){
                    $("#file_list_article_image").bind("DOMSubtreeModified", function(e) { 
                        var result = $(e.target).html().match(/href="(.+)"><img/);
                        //console.log(typeof(result[1]));
                        if (result !== null){
                            $("#article_image_url").val('');
                            var  local_img_path = result[1]; // 本地图片路径
                            $.post("{$ajax_url}", { path: local_img_path },
                            function(data){
                                if(data.status==true){
                                    $("#article_image_url").val(data.url);
                                }else{
                                    alert('图片上传到微信平台失败！');
                                }
                            });
                        }
                    });
                });
            </script>
EOF;
        return ZBuilder::make('form')
            ->setPageTitle('上传素材')// 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['text', 'name', '素材名'],
                ['select', 'type', '素材类型', '', ['image' => '图片素材', 'voice' => '声音素材', 'video' => '视频素材', 'article' => '图文(文章)素材', 'news' => '图文(外链)素材'], 'image'],

                ['image', 'image_file', '图片上传', '支持bmp/png/jpeg/gif/jpg格式,大小限制2M', '', '2048', 'bmp,png,jpeg,gif,jpg'],

                ['file', 'voice_file', '声音上传', '支持mp3/wma/wav/amr格式,大小限制5M,不超过60秒', '', '5120', 'mp3,wma,wav,amr'],
                ['text', 'video_title', '视频标题', ''],
                ['textarea', 'video_description', '视频描述', ''],
                ['file', 'video_file', '视频上传', '仅支持mp4格式,大小限制10M', '', '10240', 'mp4'],

                ['text', 'news_title', '图文标题', ''],
                ['text', 'news_description', '图文摘要', ''],
                ['text', 'news_url', '图文连接', '一般为非微信平台的URL连接'],
                ['image', 'news_image', '文章封面', '支持png/jpg格式，较好的效果为大图360*200，小图200*200', '', '0', 'png,jpg'],

                ['text', 'article_title', '文章标题', ''],
                ['text', 'article_author', '文章作者', ''],
                ['textarea', 'article_digest', '文章摘要', ''],
                ['text', 'article_content_source_url', '文章跳转URL', ''],
                ['switch', 'article_show_cover_pic', '是否显示封面', '', '1'],
                ['image', 'article_cover_pic', '文章封面', '仅支持jpg格式,大小限制64k', '', '64', 'jpg'],
                ['image', 'article_image', '文章内容图片上传', '支持png/jpg格式,大小限制1M（由于微信不支持图片外链，所以内容中的图片必须先上传到微信平台）', '', '1024', 'png,jpg'],
                ['text', 'article_image_url', '文章内容图片地址', '先上传图片到微信平台，在从这里复制图片URL到内容中去'],
                ['ckeditor', 'article_content', '文章内容', ''],
            ])
            ->setTrigger('type', 'image', 'image_file')
            ->setTrigger('type', 'voice', 'voice_file')
            ->setTrigger('type', 'video', 'video_title,video_description,video_file')
            ->setTrigger('type', 'news', 'news_title,news_description,news_url,news_image')
            ->setTrigger('type', 'article', 'article_title,article_author,article_digest,article_content_source_url,article_show_cover_pic,article_cover_pic,article_content,article_image,article_image_url')// 选中图文素材显示内容
            ->setExtraJs($upload_article_image_js)
            ->fetch();
    }

    public function edit($id = null)
    {
        if ($id === null) return $this->error('缺少参数');

        // 获取数据
        $we_material_info = WeMaterialModel::get($id);
        if (!$we_material_info) {
            return $this->error('素材不存在');
        }

        $content = json_decode($we_material_info['content'], true);

        // 保存数据
        if ($this->request->isPost()) {
            $post = $this->request->post();

            // 验证
            $result = $this->validate($post, 'WeMaterial.edit');
            // 验证失败 输出错误信息
            if (true !== $result) return $this->error($result);

            if ($post['type'] == 'news') { // 修改单篇图文
                $news_data = [
                    'title' => $post['news_title'],
                    'description' => $post['news_description'],
                    'url' => $post['news_url'],
                    'image' => $post['news_image'],
                ];
                $data['name'] = $post['name'];
                $data['content'] = json_encode($news_data);
                if (WeMaterialModel::update($data)) {
                    return $this->success('修改成功', cookie('__forward__'));
                } else {
                    return $this->error('本地数据更新失败');
                }
            } elseif ($post['type'] == 'article') { // 修改单篇文章

                if ($post['article_cover_pic'] == $we_material_info->attachment_id) {    // 没有修改缩略图就不上再次传了
                    $thumb_media_id = $content['thumb_media_id'];
                } else {
                    // easywechat 要求绝对路径
                    $root_path = $_SERVER['DOCUMENT_ROOT'];
                    $result_thumb = $this->app->material->uploadThumb($root_path . get_file_path($post['article_cover_pic']));
                    $thumb_media_id = $result_thumb->media_id;
                }
                $article_data = [
                    'title' => $post['article_title'],
                    'thumb_media_id' => $thumb_media_id,
                    'author' => $post['article_author'],
                    'digest' => $post['article_digest'],
                    'show_cover_pic' => isset($post['article_show_cover_pic']) ? 1 : 0,
                    'content_source_url' => $post['article_content_source_url'],
                    'content' => htmlspecialchars_decode($post['article_content'])
                ];

                $article = new Article($article_data);
                $result_article = $this->app->material->updateArticle($we_material_info['media_id'], $article, 0);
                $data['name'] = $post['name'];
                $data['attachment_id'] = $post['article_cover_pic'];
                $data['content'] = json_encode($article_data);
                if ($result_article->errcode == 0) {
                    $WeMaterialModel = new WeMaterialModel();
                    if ($WeMaterialModel->save($data, ['id' => $id])) {
                        return $this->success('修改成功', cookie('__forward__'));
                    } else {
                        return $this->error('本地数据更新失败');
                    }
                } else {
                    return $this->error('修改微信平台失败');
                }
            }

        }

        if ($we_material_info['type'] == 'article') {
            $we_material_info['article_title'] = $content['title'];
            $we_material_info['article_author'] = $content['author'];
            $we_material_info['article_digest'] = $content['digest'];
            $we_material_info['article_content_source_url'] = $content['content_source_url'];
            $we_material_info['article_show_cover_pic'] = $content['show_cover_pic'];
            $we_material_info['article_cover_pic'] = $we_material_info['attachment_id'];
            $we_material_info['article_content'] = $content['content'];
            $select_type = ['article' => '图文(文章)素材'];
        } elseif ($we_material_info['type'] == 'news') {
            $we_material_info['news_title'] = $content['title'];
            $we_material_info['news_description'] = $content['description'];
            $we_material_info['news_url'] = $content['url'];
            $we_material_info['news_image'] = $content['image'];
            $select_type = ['news' => '图文(外链)素材'];
        } else {
            return $this->error($we_material_info['type_text'] . ' 不能修改');
        }

        // 使用ZBuilder快速创建表单
        $ajax_url = url('wechat/material/uploadArticleImage', [], '');
        $upload_article_image_js = <<<EOF
            <script type="text/javascript">
                $(function(){
                    $("#file_list_article_image").bind("DOMSubtreeModified", function(e) { 
                        var result = $(e.target).html().match(/href="(.+)"><img/);
                        //console.log(typeof(result[1]));
                        if (result !== null){
                            $("#article_image_url").val('');
                            var  local_img_path = result[1]; // 本地图片路径
                            $.post("{$ajax_url}", { path: local_img_path },
                            function(data){
                                if(data.status==true){
                                    $("#article_image_url").val(data.url);
                                }else{
                                    alert('图片上传到微信平台失败！');
                                }
                            });
                        }
                    });
                });
            </script>
EOF;

        return ZBuilder::make('form')
            ->setPageTitle('编辑素材')// 设置页面标题
            ->addFormItems([ // 批量添加表单项
                ['hidden', 'id'],

                ['text', 'name', '素材名'],
                ['select', 'type', '素材类型', '', $select_type, $we_material_info['type']],

                //['text', 'media_id', '素材ID', '只读属性，不可修改', '', [], 'readonly'],

                ['text', 'news_title', '图文标题', ''],
                ['text', 'news_description', '图文摘要', ''],
                ['text', 'news_url', '图文连接', '一般为非微信平台的URL连接'],
                ['image', 'news_image', '文章封面', '支持png/jpg格式，较好的效果为大图360*200，小图200*200', '', '0', 'png,jpg'],

                ['text', 'article_title', '文章标题', ''],
                ['text', 'article_author', '文章作者', ''],
                ['textarea', 'article_digest', '文章摘要', ''],
                ['text', 'article_content_source_url', '文章跳转URL', ''],
                ['switch', 'article_show_cover_pic', '是否显示封面', '', '1'],
                ['image', 'article_cover_pic', '文章封面', '仅支持jpg格式,大小限制64k', '', '64', 'jpg'],
                ['image', 'article_image', '文章内容图片上传', '支持png/jpg格式,大小限制1M（由于微信不支持图片外链，所以内容中的图片必须先上传到微信平台）', '', '1024', 'png,jpg'],
                ['text', 'article_image_url', '文章内容图片地址', '先上传图片到微信平台，在从这里复制图片URL到内容中去'],
                ['ckeditor', 'article_content', '文章内容', ''],
            ])
            ->setFormData($we_material_info)// 设置表单数据
            ->setTrigger('type', 'news', 'news_title,news_description,news_url,news_image')
            ->setTrigger('type', 'article', 'article_title,article_author,article_digest,article_content_source_url,article_show_cover_pic,article_cover_pic,article_content,article_image,article_image_url')// 选中图文素材显示内容
            ->setExtraJs($upload_article_image_js)
            ->fetch();
    }

    public function delete($ids = '')
    {
        if ($this->request->isPost()) {
            $ids = input('post.ids/a');
        } else {
            $ids = input('?param.ids') ? [input('param.ids')] : [];
        }

        if (empty($ids)) return $this->error('缺少主键');

        foreach ($ids as $id) {
            if ($we_reply = WeReplyModel::where(['content' => $id])->field('id')->find()) {
                $this->error('删除失败: 自动回复中( ID: ' . $we_reply['id'] . ' )包含此素材( ID: ' . $id . ' )', cookie('__forward__'));
            }
            $info = WeMaterialModel::get($id);
            $result = $this->app->material->delete($info->media_id);
            if (isset($result->errcode) && $result->errcode == 0) {
                return $this->setStatus('delete');
            } else {
                $this->error('删除失败', cookie('__forward__'));
            }
        }
    }

    // 上传本地图片到微信的永久文章内容图片接口
    public function uploadArticleImage($path = '')
    {
        if (empty($path)) {
            return ['status' => false];
        }
        $root_path = $_SERVER['DOCUMENT_ROOT'];
        $result = $this->app->material->uploadArticleImage($root_path . $path);
        return ['status' => true, 'url' => $result->url];
    }

}