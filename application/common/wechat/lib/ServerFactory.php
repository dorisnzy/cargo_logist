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

namespace app\common\wechat\lib;

use app\common\wechat\lib\WechatFactory;

/**
 * 服务端工厂
 */
class ServerFactory {

    private static $instance = array();

    private static $server_path = '\app\common\wechat\server\\';

    private function __construct() {}

    private function __clone() {}

    /**
     * 获取对象信息
     */
    public static function getInstance($key) {
        if (self::$instance[$key]) {
            return self::$instance[$key];
        }

        $class_name = ucwords($key);
        $class = self::$server_path . $class_name;
        
        if (!class_exists($class)) {
            throw new \Exception($key.'类不存在');
        }

        $wechat = WechatFactory::getInstance();

        self::$instance[$key] = new $class($wechat);
        return self::$instance[$key];
    }
}
