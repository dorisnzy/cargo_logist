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
        // halt(config('app.system_domain'));
        $menu = array(
            'button' => array(
                0 => array(
                    'name' => '供应商',
                    'sub_button' => array(
                        0 => array(
                            'type' => 'click',
                            'name' => '下单',
                            'key'  => 'send_order',
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