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
 * 模块信息
 */
return [
  'name' => 'wechat',
  'title' => '微信',
  'identifier' => 'wechat.wangjiaqi.module',
  'icon' => 'fa fa-fw fa-users',
  'description' => '模块安装后可阅读 <a href="/admin.php/wechat/help/index.html" target="_blank">帮助文档</a><br />作者邮箱：l396@hotmail.com',
  'author' => '流风回雪',
  'author_url' => 'https://easywechat.org/',
  'version' => '1.0.0',
  'need_module' => [],
  'need_plugin' => [],
  'tables' => [
    'we_material',
    'we_reply',
  ],
  'database_prefix' => 'dp_',
  'config' => [
    [
      'text',
      'name',
      '公众号名称',
      '自行扩展时使用',
      '',
    ],
    [
      'text',
      'id',
      '公众号原始ID',
      '自行扩展时使用',
      '',
    ],
    [
      'text',
      'number',
      '微信号',
      '自行扩展时使用',
      '',
    ],
    [
      'text',
      'app_id',
      'AppID',
      '',
      '',
    ],
    [
      'text',
      'secret',
      'AppSecret',
      '',
      '',
    ],
    [
      'text',
      'token',
      'Token',
      '',
      '',
    ],
    [
      'text',
      'aes_key',
      'EncodingAESKey',
      '安全模式下请一定要填写',
      '',
    ],
    [
      'select',
      'type',
      '微信号类型',
      '自行扩展时使用',
      [
        '订阅号',
        '服务号',
      ],
      '0',
    ],
    [
      'radio',
      'debug',
      'Debug模式',
      '关闭时，不记录微信日志。日志路径 <code>/runtime/log/wechat/easywechat.log</code>',
      [
        '开启',
        '关闭',
      ],
      '1',
    ],
  ],
  'action' => [],
  'access' => [],
];
