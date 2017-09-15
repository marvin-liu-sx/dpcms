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
    'title' => '开发',
    'icon' => 'fa fa-fw fa-newspaper-o',
    'url_type' => 'module_admin',
    'url_value' => 'dev/builder/plugin',
    'url_target' => '_self',
    'online_hide' => 0,
    'sort' => 100,
    'child' => [
      [
        'title' => '快速创建',
        'icon' => 'fa fa-fw fa-sliders',
        'url_type' => 'module_admin',
        'url_value' => '',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'child' => [
          [
            'title' => '创建插件',
            'icon' => 'fa fa-fw fa-sitemap',
            'url_type' => 'module_admin',
            'url_value' => 'dev/builder/plugin',
            'url_target' => '_self',
            'online_hide' => 1,
            'sort' => 100,
          ],
          [
            'title' => '创建模块',
            'icon' => 'fa fa-fw fa-th-large',
            'url_type' => 'module_admin',
            'url_value' => 'dev/builder/module',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
          ],
        ],
      ],
      [
        'title' => '模块配置',
        'icon' => 'si si-settings',
        'url_type' => 'module_admin',
        'url_value' => 'dev/builder/config',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
      ],
      [
        'title' => '终端',
        'icon' => 'glyphicon glyphicon-sound-stereo',
        'url_type' => 'module_admin',
        'url_value' => '',
        'url_target' => '_self',
        'online_hide' => 0,
        'sort' => 100,
        'child' => [
          [
            'title' => '数据库',
            'icon' => 'fa fa-fw fa-database',
            'url_type' => 'module_admin',
            'url_value' => 'dev/terminal/database',
            'url_target' => '_self',
            'online_hide' => 0,
            'sort' => 100,
            'child' => [
              [
                'title' => '新增',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'dev/terminal/sql_add',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
              ],
              [
                'title' => '列表',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'dev/terminal/sql_list',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
              ],
              [
                'title' => '编辑',
                'icon' => '',
                'url_type' => 'module_admin',
                'url_value' => 'dev/terminal/edit',
                'url_target' => '_self',
                'online_hide' => 0,
                'sort' => 100,
              ],
            ],
          ],
        ],
      ],
    ],
  ],
];
