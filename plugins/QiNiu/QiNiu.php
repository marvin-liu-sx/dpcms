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

namespace plugins\QiNiu;

require ROOT_PATH.'plugins/QiNiu/SDK/autoload.php';
use app\common\controller\Plugin;
use app\admin\model\Attachment as AttachmentModel;
use think\Db;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 * 七牛上传插件
 * @package plugins\QiNiu
 * @author 蔡伟明 <314013107@qq.com>
 */
class QiNiu extends Plugin
{
    /**
     * @var array 插件信息
     */
    public $info = [
        // 插件名[必填]
        'name'        => 'QiNiu',
        // 插件标题[必填]
        'title'       => '七牛上传插件',
        // 插件唯一标识[必填],格式：插件名.开发者标识.plugin
        'identifier'  => 'qi_niu.ming.plugin',
        // 插件图标[选填]
        'icon'        => 'fa fa-fw fa-upload',
        // 插件描述[选填]
        'description' => '仅支持DolphinPHP1.0.6以上版本，安装后，需将【<a href="/admin.php/admin/system/index/group/upload.html">上传驱动</a>】将其设置为“七牛云”。在附件管理中删除文件，并不会同时删除七牛云上的文件。',
        // 插件作者[必填]
        'author'      => '蔡伟明',
        // 作者主页[选填]
        'author_url'  => 'http://www.caiweiming.com',
        // 插件版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
        'version'     => '1.0.0',
        // 是否有后台管理功能[选填]
        'admin'       => '0',
    ];

    /**
     * @var array 插件钩子
     */
    public $hooks = [
        'upload_attachment'
    ];

    /**
     * 上传附件
     * @param string $file 文件对象
     * @param array $params 参数
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function uploadAttachment($file = '', $params = [])
    {
        $config = $this->getConfigValue();

        $error_msg = '';
        if ($config['ak'] == '') {
            $error_msg = '未填写七牛【AccessKey】';
        } elseif ($config['sk'] == '') {
            $error_msg = '未填写七牛【SecretKey】';
        } elseif ($config['bucket'] == '') {
            $error_msg = '未填写七牛【Bucket】';
        } elseif ($config['domain'] == '') {
            $error_msg = '未填写七牛【Domain】';
        }
        if ($error_msg != '') {
            switch ($params['from']) {
                case 'wangeditor':
                    return "error|{$error_msg}";
                    break;
                case 'ueditor':
                    return json(['state' => $error_msg]);
                    break;
                case 'editormd':
                    return json(["success" => 0, "message" => $error_msg]);
                    break;
                case 'ckeditor':
                    return ck_js(request()->get('CKEditorFuncNum'), '', $error_msg);
                    break;
                default:
                    return json([
                        'code'   => 0,
                        'class'  => 'danger',
                        'info'   => $error_msg
                    ]);
            }
        }

        $config['domain'] = rtrim($config['domain'], '/').'/';

        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move(config('upload_path') . DS . 'temp', '');
        $file_info = $file->getInfo();
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = $config['ak'];
        $secretKey = $config['sk'];
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 要上传的空间
        $bucket = $config['bucket'];
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = $file_info['tmp_name'];
        // 上传到七牛后保存的文件名
        $file_name = explode('.', $file_info['name']);
        $ext = end($file_name);
        $key = $info->hash('md5').'.'.$ext;
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return json(['code' => 0, 'class' => 'danger', 'info' => '上传失败']);
        } else {
            // 获取附件信息
            $data = [
                'uid'    => session('user_auth.uid'),
                'name'   => $file_info['name'],
                'mime'   => $file_info['type'],
                'path'   => $config['domain'].$key,
                'ext'    => $info->getExtension(),
                'size'   => $info->getSize(),
                'md5'    => $info->hash('md5'),
                'sha1'   => $info->hash('sha1'),
                'module' => $params['module'],
                'driver' => 'qiniu',
            ];
            if ($file_add = AttachmentModel::create($data)) {
                unset($info);
                // 删除本地临时文件
                @unlink(config('upload_path') . DS . 'temp'.DS.$file_info['name']);
                switch ($params['from']) {
                    case 'wangeditor':
                        return $data['path'];
                        break;
                    case 'ueditor':
                        return json([
                            "state" => "SUCCESS",          // 上传状态，上传成功时必须返回"SUCCESS"
                            "url"   => $data['path'], // 返回的地址
                            "title" => $file_info['name'], // 附件名
                        ]);
                        break;
                    case 'editormd':
                        return json([
                            "success" => 1,
                            "message" => '上传成功',
                            "url"     => $data['path'],
                        ]);
                        break;
                    case 'ckeditor':
                        return ck_js(request()->get('CKEditorFuncNum'), $data['path']);
                        break;
                    default:
                        return json([
                            'code'   => 1,
                            'info'   => '上传成功',
                            'class'  => 'success',
                            'id'     => $file_add['id'],
                            'path'   => $data['path']
                        ]);
                }
            } else {
                switch ($params['from']) {
                    case 'wangeditor':
                        return "error|上传失败";
                        break;
                    case 'ueditor':
                        return json(['state' => '上传失败']);
                        break;
                    case 'editormd':
                        return json(["success" => 0, "message" => '上传失败']);
                        break;
                    case 'ckeditor':
                        return ck_js(request()->get('CKEditorFuncNum'), '', '上传失败');
                        break;
                    default:
                        return json(['code' => 0, 'class' => 'danger', 'info' => '上传失败']);
                }
            }
        }
    }

    /**
     * 安装方法
     * @author 蔡伟明 <314013107@qq.com>
     * @return bool
     */
    public function install(){
        if (!version_compare(config('dolphin.product_version'), '1.0.6', '>=')) {
            $this->error = '本插件仅支持DolphinPHP1.0.6或以上版本';
            return false;
        }
        $upload_driver = Db::name('admin_config')->where(['name' => 'upload_driver', 'group' => 'upload'])->find();
        if (!$upload_driver) {
            $this->error = '未找到【上传驱动】配置，请确认DolphinPHP版本是否为1.0.6以上';
            return false;
        }
        $options = parse_attr($upload_driver['options']);
        if (isset($options['qiniu'])) {
            $this->error = '已存在名为【qiniu】的上传驱动';
            return false;
        }
        $upload_driver['options'] .= PHP_EOL.'qiniu:七牛云';

        $result = Db::name('admin_config')
            ->where(['name' => 'upload_driver', 'group' => 'upload'])
            ->setField('options', $upload_driver['options']);

        if (false === $result) {
            $this->error = '上传驱动设置失败';
            return false;
        }
        return true;
    }

    /**
     * 卸载方法
     * @author 蔡伟明 <314013107@qq.com>
     * @return bool
     */
    public function uninstall(){
        $upload_driver = Db::name('admin_config')->where(['name' => 'upload_driver', 'group' => 'upload'])->find();
        if ($upload_driver) {
            $options = parse_attr($upload_driver['options']);
            if (isset($options['qiniu'])) {
                unset($options['qiniu']);
            }
            $options = implode_attr($options);
            $result = Db::name('admin_config')
                ->where(['name' => 'upload_driver', 'group' => 'upload'])
                ->update(['options' => $options, 'value' => 'local']);

            if (false === $result) {
                $this->error = '上传驱动设置失败';
                return false;
            }
        }
        return true;
    }
}