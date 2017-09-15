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
                        'title'       => '订单管理',
                        'icon'        => 'fa fa-fw fa-first-order',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'wxwall/index/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                ],
            ],    
        ],
    ],
];
