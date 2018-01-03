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

namespace app\wechat\controller;

use think\Controller;
use app\common\wechat\lib\WechatFactory;
use app\common\wechat\lib\RequestFactory;

/**
 * 接收微信事件响应
 */
class WechatRequest extends Controller
{
	protected $wechat; // 微信公众号

	/**
	 * 系统初始化
	 *
	 * @author dorisnzy <dorisnzy@163.com>
	 */
	protected function _initialize()
	{
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
        	// halt($e->getMessage());
            $this->wechat->response($e->getMessage());
        }
    }
}