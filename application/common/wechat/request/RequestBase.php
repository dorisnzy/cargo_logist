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

namespace  app\common\wechat\request;

use app\common\wechat\lib\WechatFactory;

/**
 * 接收微信公众号消息接口
 */
abstract class RequestBase {

    protected $wechat;
    // 接收到的信息
    protected $content;
    // 当前用户信息
    protected $userInfo;

    /**
     * 初始化
     */
    public function __construct() {
        $this->wechat = WechatFactory::getInstance();
        $this->wechat->getToken();
        $this->content = $this->wechat->request();

        // 根据微信公众号获取用户ID
        if (empty($this->content['fromusername'])) {
            throw new \Exception('参数错误');  
        }

        $this->init();
    }

    /**
     * 回调构造方法
     */
    protected function init() {}

    /**
     * 接收消息
     */
    abstract public function dispose();
}