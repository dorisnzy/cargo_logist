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
// use app\common\logic\Order as LogicOrder;

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
		// $this->modelOder = model('Order');
		// $this->modelOrderLog = model('OrderLog');
		// $this->logicOrder = new LogicOrder;
	}

	/**
	 * 分配司机送货列表信息
	 */
	public function driverList()
	{
		halt('待开发');
	}
}