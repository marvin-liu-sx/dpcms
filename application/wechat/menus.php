<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

/**
 * 菜单信息
 */
return [
  [
    'title' => '微信',
    'icon' => 'fa fa-fw fa-wechat',
    'url_type' => 'module',
    'url_value' => 'wechat/reply/index',
    'url_target' => '_self',
    'online_hide' => 0,
    'sort' => 100,
    'child' => [
      [
        'title' => '自动回复',
        'icon' => 'fa fa-fw fa-list',
        'url_type' => 'module',
        'url_value' => 'wechat/reply/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'child' => [
          [
            'title' => '添加',
            'icon' => '',
            'url_type' => 'module',
            'url_value' => 'wechat/reply/add',
            'url_target' => '_self',
            'online_hide' => 1,
            'sort' => 100,
          ],
          [
            'title' => '编辑',
            'icon' => '',
            'url_type' => 'module',
            'url_value' => 'wechat/reply/edit',
            'url_target' => '_self',
            'online_hide' => 1,
            'sort' => 100,
          ],
          [
            'title' => '删除',
            'icon' => '',
            'url_type' => 'module',
            'url_value' => 'wechat/reply/delete',
            'url_target' => '_self',
            'online_hide' => 1,
            'sort' => 100,
          ],
        ],
      ],
      [
        'title' => '素材管理',
        'icon' => 'fa fa-fw fa-file-video-o',
        'url_type' => 'module',
        'url_value' => 'wechat/material/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'child' => [
          [
            'title' => '上传',
            'icon' => 'glyphicon glyphicon-open-file',
            'url_type' => 'module',
            'url_value' => 'wechat/material/add',
            'url_target' => '_self',
            'online_hide' => 1,
            'sort' => 100,
          ],
          [
            'title' => '修改',
            'icon' => 'fa fa-fw fa-edit',
            'url_type' => 'module',
            'url_value' => 'wechat/material/edit',
            'url_target' => '_self',
            'online_hide' => 1,
            'sort' => 100,
          ],
          [
            'title' => '删除',
            'icon' => 'fa fa-fw fa-trash',
            'url_type' => 'module',
            'url_value' => 'wechat/material/delete',
            'url_target' => '_self',
            'online_hide' => 1,
            'sort' => 100,
          ],
          [
            'title' => '图文内容图片上传',
            'icon' => 'glyphicon glyphicon-open-file',
            'url_type' => 'module',
            'url_value' => 'wechat/material/uploadarticleimage',
            'url_target' => '_self',
            'online_hide' => 1,
            'sort' => 100,
          ],
        ],
      ],
      [
        'title' => '微信配置',
        'icon' => 'fa fa-fw fa-gears',
        'url_type' => 'module',
        'url_value' => 'wechat/config/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
      ],
      [
        'title' => 'FAQ',
        'icon' => 'fa fa-fw fa-question',
        'url_type' => 'module',
        'url_value' => 'wechat/help/index',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
      ],
    ],
  ],
];
