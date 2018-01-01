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

use app\common\wechat\lib;

/**
 * 微信公众号工具类工厂模型
 */
class WechatFactory {

    private static $instance;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
        if (!self::$instance) {
            $config         = self::getWechatConfig();
            self::$instance = new Wechat($config);
        }
        return self::$instance;
    }

    /**
     * 获取微信配置文件
     */ 
    private static function getWechatConfig() {
        $appid  = config('wechat.appid');
        $secret = config('wechat.secret');
        $token  = config('wechat.token');
        
        $token_file  = config('wechat.access_token_dir');
        $token_file .= config('wechat.access_token_prefix');
        $token_file .= $appid;
        $token_file .= '.json';

        $ticket_file  = config('wechat.jsapi_ticket_dir');
        $ticket_file .= config('wechat.jsapi_ticket_prefix');
        $ticket_file .= $appid;
        $ticket_file .= '.json';

        $config = array(
            'appid'                 => $appid,
            'secret'                => $secret,
            'token'                 => $token,
            'token_file'            => $token_file,
            'jsapi_ticket_file'     => $ticket_file,
            'mch_id'                => '',
            'paykey'                => '',
        );
        
        self::initKey($token_file, $ticket_file);
        
        return $config;
    }

    /**
     * 初始化key文件
     * @param string $token_file  access_token文件路径
     * @param string $ticket_file jsapi_ticket文件路径
     */
    private static function initKey($token_file, $ticket_file) {
        if(!file_exists($token_file)){
            file_put_contents($token_file, '{"access_token":"","expire_time":0}');
        }
        if(!file_exists($ticket_file)){
            file_put_contents($ticket_file, '{"jsapi_ticket":"","expire_time":0}');
        }
    }
}