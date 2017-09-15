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

namespace app\dev\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\admin\model\Hook as HookModel;
use app\dev\model\page;
use util\File;
use think\Db;
use think\Loader;

/**
 * 内容控制器
 * @package app\cms\admin
 */
class Builder extends Admin
{
	/**
	 * 创建插件
	 * @return mixed html or json
	 */
	public function plugin(){
		if(!is_writable(config('plugin_path')))
            return $this->error('您没有创建目录写入权限，无法使用此功能');
		// 获取系统里所有的钩子
		$hooks = $data_list = HookModel::column('name');
		$hooks = array_combine($hooks,$hooks);
		$html = $this->fetch();
		// 显示添加页面
        return ZBuilder::make('form')
        	->js('app')
        	->setUrl(url('build_plugin'))
            ->addFormItems([
            	['text', 'info[name]', '标识名', ''],
            	['text', 'info[title]', '插件名', ''],
            	['text', 'info[identifier]', '唯一标识', ''],
            	['icon', 'info[icon]', '图标', ''],
            	['text', 'info[author]', '作者', ''],
            	['text', 'info[author_url]', '作者链接',''],
            	['textarea', 'info[description]', '描述', ''],
            	['text', 'info[version]', '版本', ''],
            	['switch', 'info[admin]', '是否有后台管理功能', ''],
            	['select', 'hooks', '实现的钩子','',$hooks, '', 'multiple'],
            ])
            ->addBtn('<button type="button" class="btn btn-info" id="preview">预览</button>')
            ->setExtraHtml($html)
            ->setFormData([
            	'info[name]'        => 'Example',
            	'info[title]'       => '示例',
            	'info[identifier]'  => 'example.yangweijie.plugin',
            	'info[author]'      => 'yangweijie',
            	'info[description]' => '示例插件',
            	'info[version]'     => '1.0.0',
        	])
            ->fetch();
	}

	/**
	 * 预览插件文件
	 * @return string html
	 */
	public function preview_plugin(){
		$data                   =   $_POST;
        $data['info']['admin'] = isset($data['info']['admin'])? 1: 0;
        $hook_str = [];
        $hook = '';
        if(isset($data['hooks'])){
	        foreach ($data['hooks'] as $value) {
	        	$value = Loader::parseName($value,$type = 1, $ucfirst = true);
	            $hook .= <<<str
    //实现的{$value}钩子方法
    public function {$value}(\$param){

    }


str;
	        	$hook_str[] = "'{$value}'";
	        }
        }
        $hook_str = implode(',', $hook_str);

        $tpl = <<<str
<?php
namespace plugins\\{$data['info']['name']};
use app\common\controller\Plugin;

/**
 * {$data['info']['title']}插件
 * @package plugins\\{$data['info']['name']}
 * @author {$data['info']['author']}
 */
class {$data['info']['name']} extends Plugin
{
    /**
     * @var array 插件信息
     */
    public \$info = [
        // 插件名[必填]
        'name'        => '{$data['info']['name']}',
        // 插件标题[必填]
        'title'       => '{$data['info']['title']}',
        // 插件唯一标识[必填],格式：插件名.开发者标识.plugin
        'identifier'  => '{$data['info']['identifier']}',
        // 插件图标[选填]
        'icon'        => '{$data['info']['icon']}',
        // 插件描述[选填]
        'description' => '{$data['info']['description']}',
        // 插件作者[必填]
        'author'      => '{$data['info']['author']}',
        // 作者主页[选填]
        'author_url'  => '{$data['info']['author_url']}',
        // 插件版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
        'version'     => '{$data['info']['version']}',
        // 是否有后台管理功能[选填]
        'admin'       => '{$data['info']['admin']}',
    ];

    /**
     * @var array 插件钩子
     */
    public \$hooks = [{$hook_str}];

{$hook}	public static function run()
    {

    }

	/**
     * 安装方法
     * @author 蔡伟明 <314013107@qq.com>
     * @return bool
     */
    public function install(){
        return true;
    }

    /**
     * 卸载方法必
     * @author 蔡伟明 <314013107@qq.com>
     * @return bool
     */
    public function uninstall(){
        return true;
    }
}
str;
        return $tpl;
	}

	/**
	 * 预览插件文件
	 * @return string html
	 */
	public function preview_module(){
		$data                   =   $_POST;
        $tpl = <<<str
<?php
return [
    // 模块名[必填]
    'name'        => '{$data['info']['name']}',
    // 模块标题[必填]
    'title'       => '{$data['info']['title']}',
    // 模块唯一标识[必填]，格式：模块名.开发者标识.module
    'identifier'  => '{$data['info']['identifier']}',
    // 模块图标[选填]
    'icon'        => '{$data['info']['icon']}',
    // 模块描述[选填]
    'description' => '{$data['info']['description']}',
    // 开发者[必填]
    'author'      => '{$data['info']['author']}',
    // 开发者网址[选填]
    'author_url'  => '{$data['info']['author_url']}',
    // 版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
    'version'     => '{$data['info']['version']}',
    // 模块依赖[可选]，格式[[模块名, 模块唯一标识, 依赖版本, 对比方式]]
    'need_module' => [
        ['admin', 'admin.dolphinphp.module', '1.0.0']
    ],

    'config'=>[],
];
str;
        return $tpl;
	}

	// 检测表单是否可提交
	public function checkForm($type = 'plugin'){
        $data                   =   $_POST;
        $data['info']['name']   =   trim($data['info']['name']);
        if('plugin' == $type){
	        if(!$data['info']['name'])
	            return $this->error('插件标识必须');
	        //检测插件名是否合法
	        $addons_dir             =   config('plugin_path');
	        if(file_exists("{$addons_dir}{$data['info']['name']}")){
	            return $this->error('插件已经存在了');
	        }
        }else{
        	if(!$data['info']['name'])
	            return $this->error('模块名必须');
	        //检测插件名是否合法
	        $addons_dir             =   APP_PATH;
	        if(file_exists("{$addons_dir}{$data['info']['name']}")){
	            return $this->error('模块已经存在了');
	        }
        }
        return true;
    }

    // 生成插件
    public function build_plugin(){
    	$this->checkForm();
        $data                   =   $_POST;
        $data['info']['name']   =   trim($data['info']['name']);
        $addonFile              =   $this->preview_plugin();
        $addons_dir             =   config('plugin_path');
        //创建目录结构
        $files          =   [];
        $addon_dir      =   "$addons_dir{$data['info']['name']}/";
        $files[]        =   $addon_dir;
        $addon_name     =   "{$data['info']['name']}.php";
        $files[]        =   "{$addon_dir}{$addon_name}";
        $files[]    =   $addon_dir.'config.php';

        File::create_dir_or_files($files);

        //写文件
        file_put_contents("{$addon_dir}{$addon_name}", $addonFile);

        file_put_contents("{$addon_dir}config.php", '<?php
return [];');
        return $this->success('创建成功');
    }

	public function module(){
		if(!is_writable(APP_PATH))
            return $this->error('您没有创建目录写入权限，无法使用此功能');
		// 获取系统里所有的钩子
		$html = $this->fetch();
		// 显示添加页面
        return ZBuilder::make('form')
        	->js('app')
        	->setUrl(url('build_module'))
            ->addFormItems([
            	['text', 'info[name]', '模块名', ''],
            	['text', 'info[title]', '模块标题', ''],
            	['text', 'info[identifier]', '唯一标识', ''],
            	['icon', 'info[icon]', '图标', ''],
            	['text', 'info[author]', '作者', ''],
            	['text', 'info[author_url]', '作者链接',''],
            	['textarea', 'info[description]', '描述', ''],
            	['text', 'info[version]', '版本', ''],
            ])
            ->addBtn('<button type="button" class="btn btn-info" id="preview">预览</button>')
            ->setExtraHtml($html)
            ->setFormData([
            	'info[name]'        => 'example',
            	'info[title]'       => '示例',
            	'info[identifier]'  => 'example.yangweijie.module',
            	'info[author]'      => 'yangweijie',
            	'info[description]' => '示例模块',
            	'info[version]'     => '1.0.0',
        	])
            ->fetch();
	}

	// 生成插件
    public function build_module(){
    	$this->checkForm('module');
        $data                 = $_POST;
        $data['info']['name'] = trim($data['info']['name']);
        $infoFile             = $this->preview_module();
        $app_dir              = APP_PATH;
        //创建目录结构
        $files      = [];
        $module_dir = "$app_dir{$data['info']['name']}/";
        $files[]    = $module_dir;
        $infoName   = "info.php";
        $files[]    = "{$module_dir}{$infoName}";

        File::create_dir_or_files($files);

        //写文件
        file_put_contents("{$module_dir}{$infoName}", $infoFile);

        return $this->success('创建成功');
    }

	// 模块配置
	public function config(){
		return $this->moduleConfig();
	}
}
