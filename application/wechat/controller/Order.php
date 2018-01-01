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

/**
 * 供应商发布需求，第一环节
 */
class Order extends Base
{
	/**
	 * 前台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelOder = model('Order');
		$this->modelOrderLog = model('OrderLog');
	}

	/**
	 * 供应商发布需求，编辑需求
	 * @param  integer $order_id  供应商发布需求订单ID
	 */
	public function supplierEdit($order_id = 0)
	{
		if (!$order_id) {
			return $this->error('参数错误');
		}

		$map = ['order_id' => $order_id];
		$info = $this->modelOder->where($map)->find();

		if ($this->request->isPost()) {
			$param = input('post.');
			$data['target_name'] 		= $param['target_name'];
			$data['target_username'] 	= $param['target_username'];
			$data['target_tel'] 		= $param['target_tel'];
			$data['target_address'] 	= $param['target_address'];
			$data['target_lng'] 		= $param['target_lng'];
			$data['target_lat'] 		= $param['target_lat'];
			$data['order_remark'] 		= $param['order_remark'];
			$res = $this->modelOder->where($map)->update($data);

			if ($res === false) {
				return $this->error('编辑失败');
			}

			return $this->success('发布成功', url('detail', ['order_id' => $order_id]));
		}

		$this->assign('info', $info);

		$this->setMeta('发布需求');
		return $this->fetch();
	}

	/**
	 * 供应商查看订单详情
	 */
	public function detail($order_id = 0)
	{
		if (!$order_id) {
			return $this->error('参数错误');
		}

		$map = ['order_id' => $order_id];
		$info = $this->modelOder->where($map)->find();

		$this->assign('info', $info);

		// 获取订单状态日志
		$info['log'] = db('order_log')->where($map)->order('log_id asc')->select();

		$this->setMeta('订单详情');
		return $this->fetch();
	}

	/**
	 * 取货人接收订单
	 */
	public function accessOrder($order_id = 0)
	{
		if (!$order_id) {
			return $this->error('参数错误');
		}

		$map = ['order_id' => $order_id];
		$info = $this->modelOder->where($map)->find();

		if ($this->request->isPost()) {
			if ($info['order_status'] >= 40) {
				return $this->error('已经确认过，无需再次确认');
			}

			if ($info['take_uid'] != $this->userInfo['uid']) {
				return $this->error('您不是取货人，不能确认');
			}

			$data['order_status'] = 40;
			$res = $this->modelOder->where($map)->update($data);
			if ($res === false) {
				return $this->error('确认有误');
			}

			// 添加订单日志-----取货人确认成功
			$log_data['order_id'] = $order_id;
			$log_data['order_status'] = 40;
			$log_data['op_uid']  = $this->userInfo['uid'];
			$log_data['log_time'] = time();
			$log_data['log_msg'] = '已经指派取货人';
			$res = $this->modelOrderLog->save($log_data);
			if ($res === false) {
				$data['order_status'] = $info['order_status'];
				$this->modelOder->where($map)->update($data);
				return $this->error('确认有误');
			}

			return $this->success('确认成功');
		}

		$this->assign('info', $info);

		// 获取订单状态日志
		$info['log'] = db('order_log')->where($map)->order('log_id asc')->select();

		$this->assign('action', $this->request->action());
		
		$this->setMeta('接收订单');
		return $this->fetch('detail');
	}

	/**
	 * 司机确认到达取货点
	 */
	public function reachTarget($order_id = 0)
	{
		if (!$order_id) {
			return $this->error('参数错误');
		}

		$map = ['order_id' => $order_id];
		$info = $this->modelOder->where($map)->find();

		if ($this->request->isPost()) {
			if ($info['order_status'] >= 60) {
				return $this->error('已经确认过，无需再次确认');
			}

			if ($info['take_uid'] != $this->userInfo['uid']) {
				return $this->error('您不是取货人，不能确认');
			}

			$data['order_status'] = 60;
			$res = $this->modelOder->where($map)->update($data);
			if ($res === false) {
				return $this->error('确认有误');
			}

			// 添加订单日志-----取货人确认成功
			$log_data['order_id'] = $order_id;
			$log_data['order_status'] = 60;
			$log_data['op_uid']  = $this->userInfo['uid'];
			$log_data['log_time'] = time();
			$log_data['log_msg'] = '取货人已到达取货地点';
			$res = $this->modelOrderLog->save($log_data);
			if ($res === false) {
				$data['order_status'] = $info['order_status'];
				$this->modelOder->where($map)->update($data);
				return $this->error('确认有误');
			}

			return $this->success('确认成功');
		}

		$this->assign('info', $info);

		// 获取订单状态日志
		$info['log'] = db('order_log')->where($map)->order('log_id asc')->select();

		$this->assign('action', $this->request->action());
		
		$this->setMeta('确认到达取货点');
		return $this->fetch('detail');
	}


	/**
	 * 取货人填写取货信息
	 */
	public function takeGoods($order_id = 0)
	{
		if (!$order_id) {
			return $this->error('参数错误');
		}

		$map = ['order_id' => $order_id];
		$info = $this->modelOder->where($map)->find();

		$this->assign('action', $this->request->action());
		$this->assign('info', $info);
		
		$this->setMeta('填写取货信息');
		return $this->fetch();
	}
}