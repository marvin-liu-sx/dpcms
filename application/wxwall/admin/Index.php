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

namespace app\wxwall\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use think\Db;

/**
 * 仪表盘控制器
 * @package app\cms\admin
 */
class Index extends Admin
{
    /**
     * 订单管理
     * @author marvin9002 <448332799@qq.com>
     * @return mixed
     */
    public function index()
    {
        
        return ZBuilder::make('table')->setPageTitle('微信墙订单')->setPageTips('这是页面提示信息')->fetch();
//        $this->assign('document', Db::name('cms_document')->where('trash', 0)->count());
//        $this->assign('column', Db::name('cms_column')->count());
//        $this->assign('page', Db::name('cms_page')->count());
//        $this->assign('model', Db::name('cms_model')->count());
//        $this->assign('page_title', '仪表盘');
//        return $this->fetch(); // 渲染模板
    }
    
    public function test(){
        echo '123';
    }
}