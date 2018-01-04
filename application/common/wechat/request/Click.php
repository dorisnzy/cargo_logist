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

use app\common\wechat\request\RequestBase;
use app\common\logic\Order;
use app\common\logic\WechatMessage;

/**
 * 接收菜单点击事件
 */
class Click extends RequestBase {

	protected $logicOrder;

	// 模板消息对象
	protected $wechatMsg;
	
	protected function init() 
	{
		$this->logicOrder = new Order;
		$this->wechatMsg  = new WechatMessage;

        $user_info = model('User')->getUserInfoByOpenid($this->content['fromusername']);
        
        if (!$user_info) {
            throw new \Exception('用户信息不存在');
        }

        $this->userInfo = $user_info;
	}

    /**
     * 接收消息
     */
    public function dispose()
    {
        $key = $this->content['eventkey'];

        switch ($key) {
        	/* 供应商发布需求 */ 
        	case 'send_order' :
        		// 新增订单信息
        		$order_id = $this->logicOrder->setConfig($this->userInfo)->sendOrder();
        		if (!$order_id) {
        			throw new \Exception($this->logicOrder->getError());
        		}

        		// 发送微信图文消息给当前供应商，提示发布成功
        		$res =$this->wechatMsg->supplierSendMsg($this->userInfo['openid'], $order_id);
        		if (!$res) {
        			throw new \Exception($this->wechatMsg->getError());
        		}
                
                echo '';die;   
        		// 回复普通消息
        		// $this->wechat->response('发布成功');
        		break;
        }
    }
}