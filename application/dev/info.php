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
  'name' => 'dev',
  'title' => '开发',
  'identifier' => 'dev.yangweijie.module',
  'author' => 'Yangweijie',
  'version' => '1.0.0',
  'description' => '开发者工具模块',
  'config' => [
    [
      'select',
      'codemirror_theme',
      'codemirror主题',
      '',
      [
        '3024 day' => '3024 day',
        '3024-night' => '3024-night',
        'ambiance' => 'ambiance',
        'base16-dark' => 'base16-dark',
        'base16-light' => 'base16-light',
        'blackboard' => 'blackboard',
        'cobalt' => 'cobalt',
        'eclipse' => 'eclipse',
        'elegant' => 'elegant',
        'erlang-dark' => 'erlang-dark',
        'lesser-dark' => 'lesser-dark',
        'midnight' => 'midnight',
      ],
      'ambiance',
    ],
  ],
  'tables' => [
    'dev_database_sql',
  ],
  'database_prefix' => 'wwj_',
];
