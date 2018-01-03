<?php
// +----------------------------------------------------------------------
// | 货物运送系统
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: dorisnzy <dorisnzy@163.com>
// +----------------------------------------------------------------------
// | Date: 2017-12-30
// +----------------------------------------------------------------------

namespace app\common\logic;

use app\common\logic\Base;
use app\common\wechat\lib\WechatFactory;

/**
 * 微信消息管理
 */
class WechatMessage extends Base
{
	protected $wechat;
	// 供应商收到的消息模板
	protected $supplierSendMsg       = '您的需求发布成功，等待分配取货人，请保持电话畅通';
	protected $supplierDesignateSucc = '已为您指派取货人，取货人正在路上，请保持电话畅通';
	protected $supplierDestination   = '取货人已到达取货地点，快去交货吧';
	protected $supplierTakeSucc      = '已取货，等待分配司机送货';

	// 取货人收到的消息模板
	protected $takeNew 				 = '您有新的取货订单';
	protected $takeComfirm 			 = '订单已经确认快去取货吧';
	protected $takeTarget 		     = '已到达取货地点';
	protected $takeDesignate 		 = '货物已经接收，快安排司机送货吧';

	// 初始化
	protected function logicInit()
	{
		$this->wechat = WechatFactory::getInstance();
		$this->wechat->getToken();
	}



// ---------------------------  具体步骤发送消息集合 ----------------------------

    /**
     * 指派订单成功
     */
    public function designateOrder()
    {
        // 发送消息给取货人
        $this->takeNew($this->config['target_openid'], $this->config['order_id']);
        // 发送消息给供应商
        $this->supplierDesignateSucc($this->config['supplier_openid'], $this->config['order_id']);
    }




// ---------------------------------- 供应商 ------------------------------------

	/**
	 * 需求发布成功，发送消息给供应商
	 *
	 * @param  [type] $openid 微信open
	 * @param  [type] $order_id 发布需求订单ID
	 *
	 * @return boolean        成功-true，失败-false
	 */
	public function supplierSendMsg($openid, $order_id)
	{
		$url = url('wechat/order/supplieredit', ['order_id' => $order_id]);
		return $this->sendMsg($openid, $url, $this->supplierSendMsg);
	}

    /**
     * 取货人指派成功，发送消息给供应商
     *
     * @param  [type] $openid 微信open
     * @param  [type] $order_id 发布需求订单ID
     *
     * @return boolean        成功-true，失败-false
     */
    public function supplierDesignateSucc($openid, $order_id)
    {
        $url = url('wechat/order/detail', ['order_id' => $order_id]);
        return $this->sendMsg($openid, $url, $this->supplierDesignateSucc);
    }




// ------------------------------ 取货人 -----------------------------------------

    /**
     * 发布消息给取货者-有新的订单
     *
     * @param  [type] $openid 微信open
     * @param  [type] $order_id 发布需求订单ID
     *
     * @return boolean        成功-true，失败-false
     */
    public function takeNew($openid, $order_id)
    {
        $url = url('wechat/order/accessOrder', ['order_id' => $order_id]);
        return $this->sendMsg($openid, $url, $this->takeNew);
    }

	/**
     * 发送模版消息
     * @param   interger    $openid      用户openid
     * @param   string      $url            通知详情地址
     * @param   string      $title          通知标题
     */
    public function sendMsg($openid='', $url='', $title='') {

        $openid         = empty($openid) ? I('openid') : $openid;
        $url            = empty($url) ? I('url') : $url;
        $title          = empty($title) ? I('title') : $title;

        if (empty($openid)) {
        	$this->setError('用户openid不能为空');
        	return false;
        }
        if (empty($title)) {
        	$this->setError('通知内容不能为空');
        	return false;
        }
        if (empty($url)) {
        	$this->setError('用户查看通知地址不能为空');
        	return false;
        }

        $template_id = '6_0QwlVjspzkoei_qlfAkllFuPL-KND4h2AJIQ5NDkQ'; //测试模版ID

        $url = request()->domain() . $url;

        $content = array(
            'touser'        => $openid,
            'template_id'   => $template_id,
            'url'           => $url,
        );
        $content['data'] = array(
            'first' => array(
                    'value' => '你有新的消息', //标题
                    'color' => '#173177',
            ),
            'keyword1' => array(
                    'value' => $title,
                    'color' => '#173177', //姓名
            ),
            'keyword2' => array(
                    'value' => '发送成功',
                    'color' => '#173177', //意见内容
            ),
            'keyword3' => array(
                    'value' => date('Y-m-d H:i'), //处理时间
                    'color' => '#173177',
            ),
            'remark' => array(
                    'value' => '点击查看详情', //内容
                    'color' => '#173177',
            ),
        );

        return $this->send($content);
    }

    /**
     * 发模版消息
     */
    protected function send($content) {
        $res = $this->wechat->sendTemplate($content);
        if (!$res) {
            $error = $this->wechat->getError();
            $this->setError($error);
            return false;
        }
        return true;
    }
}

