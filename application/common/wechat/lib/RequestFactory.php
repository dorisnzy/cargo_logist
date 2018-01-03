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

/**
 * 接收微信消息接口工厂类
 */
class RequestFactory {

    private static $request_path = '\app\common\wechat\request\\';

    private static $instance = array();

    private function __construct() {}

    private function __clone() {}

    /**
     * 实例化具体响应事件接口
     * @param array $request 响应的内容消息
     * @return object 具体响应事件对象
     */ 
    public static function getInstance($request) {

        $request = array_change_key_case($request, CASE_LOWER);
        
        switch ($request['msgtype']){
            // 事件消息
            case 'event' : 

                $key = $request['event'];
                break;
            // 其它消息
            default :

                $key = $request['msgtype'];
        }
throw new \Exception('不存在的消息类型');
        $key = strtolower($key);

        if (!$key) {

            throw new \Exception('不存在的消息类型');
        }

        return self::getObj($key);
    }

    /**
     * 获取实例
     * @param string $key 对象实例键
     * @param obj 返回对象实例
     */ 
    private static function getObj($key) {
        if (empty(self::$instance[$key])) {

            self::$request_path;

            $class_name = ucwords($key);

            $class = self::$request_path . $class_name;
            if (!class_exists($class)) {

                throw new \Exception($key.'类不存在');
            }

            self::$instance[$key] = new $class();
        }
        return self::$instance[$key];
    }
}