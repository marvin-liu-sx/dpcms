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
        'title'       => '微信墙',
        'icon'        => 'fa fa-fw fa-google-wallet',
        'url_type'    => 'module_admin',
        'url_value'   => 'wxwall/index/test',
        'url_target'  => '_self',
        'online_hide' => 0,
        'sort'        => 100,
        'child'       => [
            [
                'title'       => '常用操作',
                'icon'        => 'fa fa-fw fa-folder-open-o',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '仪表盘',
                        'icon'        => 'fa fa-fw fa-tachometer',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/index/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                    [
                        'title'       => '财务统计',
                        'icon'        => 'fa fa-fw fa-money',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/finance/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                ],
            ], 
            [
               'title'       => '订单管理',
                'icon'        => 'fa fa-fw fa-th-list',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '订单管理',
                        'icon'        => 'fa fa-fw fa-tachometer',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/order/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                ], 
            ],
            [
               'title'       => '用户管理',
                'icon'        => 'fa fa-fw fa-id-badge',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '互动用户',
                        'icon'        => 'fa fa-fw fa-wechat',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/wechat/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                ], 
            ],
             [
               'title'       => '弹幕管理',
                'icon'        => 'fa fa-fw fa-comments-o',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '弹幕管理',
                        'icon'        => 'fa fa-fw fa-comment-o',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/barrage/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                ], 
            ],
            [
               'title'       => '视频管理',
                'icon'        => 'fa fa-fw fa-video-camera',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '视频管理',
                        'icon'        => 'fa fa-fw fa-file-video-o',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/video/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                ], 
            ],
            [
               'title'       => '音频管理',
                'icon'        => 'fa fa-fw fa-music',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '音频管理',
                        'icon'        => 'fa fa-fw fa-headphones',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/music/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                ], 
            ],
            [
               'title'       => '照片管理',
                'icon'        => 'fa fa-fw fa-photo',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '照片管理',
                        'icon'        => 'fa fa-fw fa-file-image-o',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/photo/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                ], 
            ],
        ],
    ],
];
