<?php
// +----------------------------------------------------------------------
// | 货物运送系统
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: dorisnzy <dorisnzy@163.com>
// +----------------------------------------------------------------------
// | Date: 2017-12-25
// +----------------------------------------------------------------------
namespace app\common\wechat\server;

use app\common\wechat\server\Drive;

/**
 * 微信菜单管理
 */
class Menu extends Drive {

    /**
     * 创建菜单
     * @param array $menu 菜单列表
     */
    public function create($menu = array()) {
        // dump(C('SYSTEM_URL'));die;
        $menu = array(
            'button' => array(
                0 => array(
                    'name' => '我是市民',
                    'sub_button' => array(
                        0 => array(
                            'type' => 'view',
                            'name' => '个人中心',
                            'url'  => C('SYSTEM_URL').'/Public/wechat/person.html'
                        ),
                        1 => array(
                            'type' => 'view',
                            'name' => '代表听我说',
                            'url'  => C('SYSTEM_URL').'/Public/wechat/select.html'
                        ),
                        2 => array(
                            'type' => 'view',
                            'name' => '征求意见',
                            'url'  => C('SYSTEM_URL').'/Public/wechat/collect.html'
                        ),
                        3 => array(
                            'type' => 'view',
                            'name' => '旁听报名',
                            'url'  => C('SYSTEM_URL').'/Public/wechat/hearing.html'
                        ),
                    ),
                ),

                1 => array(

                    'name' => '我是代表',
                    'sub_button' => array(
                        0 => array(
                            'type' => 'view',
                            'name' => '账号绑定',
                            'url' => C('SYSTEM_URL').'/Public/wechat/binding.html'
                        ),
                        1 => array(
                            'type' => 'view',
                            'name' => '我的通知',
                            'url' => C('SYSTEM_URL').'/Public/wechat/user-notice.html'
                        ),
                        2 => array(
                            'type' => 'view',
                            'name' => '市民留言',
                            'url' => C('SYSTEM_URL').'/Public/wechat/message.html'
                        ),
                        3 => array(
                            'type' => 'view',
                            'name' => '代表履职',
                            'url' => C('SYSTEM_URL').'/Public/layim/index.html'
                        ),
                        4 => array(
                            'type' => 'scancode_push',
                            'name' => '代表签到',
                            'key' => 'rselfmenu_0_1',
                            'sub_button' => array(),
                        ),
                    ),
                ),

                2 => array(
                    'name' => '直通车',
                    'sub_button' => array(
                        0 => array(
                            'type' => 'view',
                            'name' => '会议专题',
                            'url' => 'http://m.kmrd.cn/ztzl/rmdbdhhy/2017nssjychy/'
                        ),
                        1 => array(
                            'type' => 'view',
                            'name' => '代表信息',
                            'url' => C('SYSTEM_URL').'/Public/wechat/organizeSelect.html'
                        ),
                        2 => array(
                            'type' => 'view',
                            'name' => '履职平台登录',
                            'url' => C('SYSTEM_URL').'/index.php?m=Sys&c=WxLogin&a=index'
                        ),
                        3 => array(
                            'type' => 'view',
                            'name' => '代表工作站',
                            'url' => 'http://dbgzz.kmrd.cn/wechat/index.html'
                        ),
                        4 => array(
                            'type' => 'view',
                            'name' => '昆明人大订阅号',
                            'url' => 'http://www.kmrd.cn/wxtz.html'
                        ),
                    ),
                ),

            ),
            
        );
        $res = $this->wechat->menu_create($menu);
        if (!$res) {
            $error = $this->wechat->getError();
            throw new \Exception($error);
        }
        return true;
    }

    /**
     * 获取菜单
     */
    public function get() {
        return $this->wechat->menus();
    }

    /**
     * 删除菜单
     */
    public function delete() {
        $res = $this->wechat->menu_delete();
        if (!$res) {
            $error = $this->wechat->getError();
            throw new \Exception($error);
        }
        return true;
    }

    /**
     * 修改菜单
     */
    public function update() {

    }   
}