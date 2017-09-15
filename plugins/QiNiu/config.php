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
 * 插件配置信息
 */
return [
    ['text', 'ak', 'AccessKey', '登录七牛平台，访问 <a href="https://portal.qiniu.com/user/key" target="_blank">https://portal.qiniu.com/user/key</a> 查看'],
    ['text', 'sk', 'SecretKey', '登录七牛平台，访问 <a href="https://portal.qiniu.com/user/key" target="_blank">https://portal.qiniu.com/user/key</a> 查看'],
    ['text', 'bucket', 'Bucket', '上传的空间名'],
    ['text', 'domain', 'Domain', '空间绑定的域名，以 <code>http://</code> 开头，以 <code>/</code> 结尾', 'http://'],
];
