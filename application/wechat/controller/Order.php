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

use app\wechat\Controller\Base;

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

	}

	/**
	 * 供应商发布需求，编辑需求
	 */
	public function supplierEdit()
	{
		$this->setMeta('发布需求');
		return $this->fetch();
	}
}