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

namespace app\index\controller;

use app\index\model\Module;
use think\Route;

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Home {

    public function index() {
        // 默认跳转模块
//        $this->redirect( 'cms/index/index');
//        if (config('home_default_module') != 'index') {
//            $this->redirect(config('home_default_module'). '/index/index');
//        }
//        Route::rule([
//        '' => 'cms/index/index',
//        ]);
        
        $Module = Module::getModule();
        $config = [];
        $menu = [];
        if (count($Module) != 0) {
            foreach ($Module as $name => $title) {
                $conf = Module::getInfoFromFile($name);
                $rule = $conf['route'];
//                var_dump($conf);
//                var_dump($conf['route']["[{$name}]"]);die;
                Route::group($name,$rule);
//                var_dump(Module::getInfoFromFile($name));
//                Route
//                $conf=Module::getInfoFromFile($name);
//                $conf=isset($conf['home'])?$conf['home']:null;
//                if($conf['ischild']==0){
//                    $menu[$conf['menu_order']]=$conf['menu'];
//                }
//                $config[]=  $conf;
            }
        }
//        var_dump($Module);


//        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> DolphinPHP V1.0.0<br/><span style="font-size:30px">极速 · 极简 · 极致</span></p></div>';
    }

    public function test() {
        //
        /**
         * 1.读取除系统模块外的所有模块（缓存数据）
         * 2.读取模块的配置信息【查找Home配置】
         * 3.生成菜单[绑定域名]
         * 4.加载模块内容
         */
        $Module = Module::getModule();
        var_dump($Module);
    }

}
