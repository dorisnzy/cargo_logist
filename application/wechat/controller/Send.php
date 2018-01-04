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

use app\wechat\controller\Base;
use app\common\logic\Attachment;
use app\common\logic\Send as LogicSend;

/**
 * 司机送货，第二环节
 */
class Send extends Base
{
	/**
	 * 前台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelOder = model('Order');
		$this->modelSend = model('Send');
		$this->modelDriver = model('UserDriver');
		$this->logicSend = new LogicSend;
	}

	/**
	 * 获取空闲的司机列表
	 */
	public function driverList($order_id = 0)
	{
		// 检查订单是否存在
		$map = ['order_id' => $order_id];
		$info = $this->modelOder->where($map)->find();

		if (!$order_id) {
			return $this->error('非法请求');
		}

		$map = [];

        // 关键词搜索
        if ($this->request->param('keyword')) {
            $map['u.nickname|u.username|u.email|u.mobile|u.realname'] = [
            	'like',
            	'%'. $this->request->param('keyword') . '%'
            ];
        }

        // 按空闲状态搜索
        $map['d.work_status'] = 0;

		if ($this->request->isAjax()) {

			$count = $this->modelDriver
				->alias('d')
				->where($map)
				->join('__USER__ u', 'u.uid=d.uid')
				->count()
			;

			$list = $this->modelDriver
				->alias('d')
				->join('__USER__ u', 'u.uid=d.uid')
				->page($this->modelDriver->getPageNow(), $this->modelDriver->getPageLimit())
                ->order('d.uid asc')
				->where($map)
				->select()
			;

			if (!$list) {
                return $this->error('信息不存在');
            }

			// 获取头像
			$attachment = new \app\common\logic\Attachment;
			foreach ($list as $key => $item) {
				$headimg = $attachment->getUrls($item->uid, 1);
				$list[$key]['headimg'] = !empty($headimg[0]) ? $headimg[0] : '';
			}

			$this->assign('list', $list);

			$html = $this->fetch('driverlist_ajax');

			$data = [
                'list'  => $html,
                'count' => $count,
                'limit' => $this->modelDriver->getPageLimit()
            ];

            return $this->success('获取成功', '', $data);
		}

		$this->setMeta('指派司机送货');
		$this->assign('order_id', $order_id);

		return $this->fetch();
	}

	/** 
	 * 发布送货需求给司机【指派司机送货】
	 */
	public function send($order_id = 0)
	{
		$map = ['order_id' => $order_id];
		$info = $this->modelOder->where($map)->find();

		if (!$order_id) {
			return $this->error('非法请求');
		}

		if ($this->request->isPost()) {
			// 添加送货单数据
			$data 					= input('post.');
			$data['merchant_id'] 	= $info['merchant_id'];
			$data['supplier_uid'] 	= $info['supplier_uid'];
			$data['order_id'] 		= $info['order_id'];
			$data['site_sn']		= $info['site_sn'];
			$data['send_remark']	= empty($data['send_remark']) ?: '';

			$send_id = $this->logicSend->setConfig($data)->send();
			if (!$send_id) {
				return $this->error($this->logicSend->getError());
			}

			// 发送微信消息
			$supplier_openid = db('user')->where(['uid' => $info['supplier_uid']])->value('openid');
			$driver_openid   = db('user')->where(['uid' => $data['driver_uid']])->value('openid');
			$message = new \app\common\logic\WechatMessage;
			$msg_data = [
				'send_id' 			=> $send_id,
				'supplier_openid' 	=> $supplier_openid,
				'driver_openid'     => $driver_openid,
			];
			// TODO::
			$message->setConfig($msg_data)->comfirmSucc();

			return $this->success('指派成功', url('driverList', ['order_id' => $order_id]));
		} 

		return $this->error('非法请求');
	}
}