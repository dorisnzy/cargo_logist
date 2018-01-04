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

/**
 * 取货订单服务层
 */
class Order extends Base
{	
	// 供应商信息
	protected $supplier;

	// 供应商用户信息
	protected $supplierUser;

	// 目的地商家信息
	protected $target;

	// 目标目的地商家用户信息
	protected $targetUser;

	/**
	 * 新增订单日志
	 */
	public function addOrderLog()
	{
		$data['order_id'] = $this->config['order_id'];
		$data['order_status'] = $this->config['order_status'];
		$data['op_uid'] = $this->config['op_uid'];

		$info = db('order_log')->where($data)->find();
		if ($info) {
			$this->setError('订单日志已经存在');
			return false;
		}

		$data['log_time'] = time();
		$data['log_msg'] = $this->config['log_msg'];

		$res = db('order_log')->insert($data);
		if (!$res) {
			$this->setError('新增失败');
			return false;
		}

		return true;
	}

	/**
	 * 供应商发布需求订单
	 *
	 * @author dorisnzy <dorisnzy@163.com>
	 *
	 * @return mixed 成功-订单ID,失败-false
	 */
	public function sendOrder()
	{
		// 检查是否是供应商
		if (!$this->checkSupplier($this->config['uid'])) {
			return false;
		}

		// 检查是否有供应商商家认领
		if (!$this->supplierUser['merchant_id']) {
			$this->setError('您目前没有分配到具体供应商家，请联系管理员');
			return false;
		}

		// 处理订单数据
		$data['merchant_id'] 	= $this->supplierUser['merchant_id'];
		$data['supplier_uid'] 	= $this->config['uid'];
		$data['publish_time']	= time();
		$data['maybe_time']		= time() + (30 * 60); // 自动在发布时间后加三十分钟
		$data['order_status'] 	= 0;

		$order_id = db('Order')->insertGetId($data);
		if (!$order_id) {
			$this->setError('发布失败');
			return false;
		}

		// 添加订单日志
		$this->config['order_id']     = $order_id;
		$this->config['order_status'] = 0;
		$this->config['op_uid']       = $this->config['uid'];
		$this->config['log_msg']      = '发布成功,平台收到待分配取货者';
		$this->addOrderLog();

		return $order_id;
	}

	/**
	 * 校验是否是供应商用户
	 * @return bolean  true-成功，false-失败
	 */
	protected function checkSupplier($uid)
	{
		$map['uid']    = $uid;
		$supplier_user = db('user_supplier')->where($map)->find();
		if (!$supplier_user) {
			$this->setError('您不是供应商');
			return false;
		}

		$this->supplierUser = $supplier_user;
		return true;
	}

	/**
	 * 获取供应商信息
	 */
	protected function getSupplier($merchant_id)
	{
		$map['merchant_id'] = $merchant_id;
		$map['type']        = 1;
		$supplier = db('merchant')->where($map)->find();
		if ($supplier) {
			$this->setError('供应商信息不存在');
			return false;
		}

		$this->supplier = $supplier;
		return $supplier;
	}

	/**
	 * 获取目的地商家信息
	 */
	protected function getTarget()
	{

	}
}