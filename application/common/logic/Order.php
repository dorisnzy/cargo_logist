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
	protected $config;
	
	/**
	 * 设置配置
	 *
	 * @param [type] $config [配置信息]
	 */
	public function setConfig($config)
	{
		$this->config = $config;
		return $this;
	}

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
}