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
 * 司机送货订单服务层
 */
class Send extends Base
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
	public function addSendLog()
	{
		$data['send_id'] 		= $this->config['send_id'];
		$data['send_status'] 	= $this->config['send_status'];
		$data['op_uid'] 		= $this->config['op_uid'];

		$info = db('send_log')->where($data)->find();
		if ($info) {
			$this->setError('订单日志已经存在');
			return false;
		}

		$data['log_time'] = time();
		$data['log_msg'] = $this->config['log_msg'];

		$res = db('send_log')->insert($data);
		if (!$res) {
			$this->setError('新增失败');
			return false;
		}

		return true;
	}

	/**
	 * 发布送货订单
	 */
	public function send()
	{
		// 检查是否是司机
		
		// 订单数据处理
		$data['merchant_id']  = $this->config['merchant_id'];
		$data['supplier_uid'] = $this->config['supplier_uid'];
		$data['publish_time'] = time();
		$data['maybe_time']   = time() + (60 * 60); // 自动在发布时间后加三十分钟
		$data['send_remark']  = $this->config['send_remark'];
		$data['site_sn']   	  = $this->config['site_sn'];

		if (empty($this->config['driver_uid'])) {
			$data['driver_uid']   = $this->config['driver_uid'];
		}
		

		$send_id = db('Send')->insertGetId($data);
		if (!$send_id) {
			$this->setError('发布失败');
			return false;
		}

		// 添加订单日志
		$this->config['send_id']     = $send_id;
		$this->config['send_status'] = 0;
		$this->config['op_uid']      = $this->config['uid'];
		$log_msg = empty($this->config['driver_uid']) ? get_send_status(0) : get_send_status(20);
		$this->config['log_msg']     = $log_msg;
		$this->addOrderLog();

		return $send_id;
	}
}