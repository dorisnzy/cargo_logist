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
 * 首页控制器
 */
class Index extends Base
{
	/**
	 * 前台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{

	}

	public function index()
	{
		// halt('hello world!');
		$this->setMeta('首页');
		return $this->fetch();
	}
}
