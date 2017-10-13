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

namespace app\index\model;

use think\Model;

/**
 * 模块模型
 * @package app\admin\model
 */
class Module extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_MODULE__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    
    //系统模块
    protected static $systemModule=['admin','user'];

    /**
     * 获取所有模块的名称和标题
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public static function getModule()
    {
        $modules = cache('modules');
        if (!$modules) {
            $where['name']=[
                'not in',  self::$systemModule
            ];
            $modules = self::where('status', '>=', 0)->where($where)->order('id')->column('name,title');
            // 非开发模式，缓存数据
            if (config('develop_mode') == 0) {
                cache('modules', $modules);
            }
        }
        return $modules;
    }

 

    /**
     * 从文件获取模块信息
     * @param string $name 模块名称
     * @author 蔡伟明 <314013107@qq.com>
     * @return array|mixed
     */
    public static function getInfoFromFile($name = '')
    {
        $info = [];
        if ($name != '') {
            // 从配置文件获取
            if (is_file(APP_PATH. $name . '/info.php')) {
                $info = include APP_PATH. $name . '/info.php';
            }
        }
        return $info;
    }

    /**
     * 检查模块模块信息是否完整
     * @param string $info 模块模块信息
     * @author 蔡伟明 <314013107@qq.com>
     * @return bool
     */
    private function checkInfo($info = '')
    {
        $default_item = ['name','title','author','version'];
        foreach ($default_item as $item) {
            if (!isset($info[$item]) || $info[$item] == '') {
                return false;
            }
        }
        return true;
    }

    /**
     * 获取模型配置信息
     * @param string $name 模型名
     * @param string $item 指定返回的模块配置项
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public static function getConfig($name = '', $item = '')
    {
        $name = $name == '' ? request()->module() : $name;

        $config = cache('module_config_'.$name);
        if (!$config) {
            $config = self::where('name', $name)->value('config');
            if (!$config) {
                return [];
            }

            $config = json_decode($config, true);
            // 非开发模式，缓存数据
            if (config('develop_mode') == 0) {
                cache('module_config_'.$name, $config);
            }
        }

        if (!empty($item)) {
            $items = explode(',', $item);
            if (count($items) == 1) {
                return isset($config[$item]) ? $config[$item] : '';
            }

            $result = [];
            foreach ($items as $item) {
                $result[$item] = isset($config[$item]) ? $config[$item] : '';
            }
            return $result;
        }
        return $config;
    }



    /**
     * 从文件获取模块菜单
     * @param string $name 模块名称
     * @author 蔡伟明 <314013107@qq.com>
     * @return array|mixed
     */
    public static function getMenusFromFile($name = '')
    {
        $menus = [];
        if ($name != '' && is_file(APP_PATH. $name . '/menus.php')) {
            // 从菜单文件获取
            $menus = include APP_PATH. $name . '/menus.php';
        }
        return $menus;
    }
}