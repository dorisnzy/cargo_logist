<?php
// +----------------------------------------------------------------------
// | 接收微信公众号响应入口
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://kunming.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: nongzhengyi <dorisnzy@163.com>
// +----------------------------------------------------------------------
// | History:
// |    [2017-08-11]     nongzhengyi     first release
// +----------------------------------------------------------------------

namespace Api\Controller;

use Think\Controller;
use Common\Wechat\Lib\WechatFactory;
use Common\Wechat\Lib\RequestFactory;

class WechatRequestController extends Controller {
    protected $wechat; // 微信公众号

    protected function _initialize() {
        $this->wechat = WechatFactory::getInstance();
    } 

    /**
     * 接收消息
     */ 
    public function index() {
        $valid = $this->wechat->valid();
        $content = $this->wechat->request();
        try {
            $obj = RequestFactory::getInstance($content);
            $obj->dispose();
        } catch (\Exception $e) {

            $this->wechat->response($e->getMessage());
        }
    }
}