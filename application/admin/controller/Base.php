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

namespace app\admin\controller;

use think\Controller;

/**
 * 后台公共控制器
 */
class Base extends Controller 
{
	/**
	 * 系统初始化
	 *
	 * @return void
	 */
	protected function _initialize()
	{
		$this->_init();
	}

	/**
	 * 后台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{

	}

	/**
	 * 获取菜单
	 *
	 * @return array 菜单列表
	 */
	public function getMenu()
	{
		
	}
}