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
        $order=Db::name('wxwall_order')->count();
        $barrage=Db::name('wxwall_barrage')->count();
        $wechat_user=Db::name('wxwall_wechat_user')->count();
        $total=$wechat_user!=0 && $order!=0? ($barrage/$wechat_user)/$order:0;
        $this->assign('order',$order );
        $this->assign('barrage', $barrage);
        $this->assign('wechat_user', $wechat_user);
        $this->assign('total', $total);
        $this->assign('page_title', '微信墙订单');
        return $this->fetch(); // 渲染模板
    }
    
    public function test(){
        echo '123';
    }
}