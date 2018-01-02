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

use think\Model;

/**
 * 逻辑服务层基础类
 */
class Base extends Model
{
	protected $errmsg;

	/**
	 * 获取错误信息
	 */
	public function getError(){
		return $this->errmsg;
	}

	/**
	 * 设置错误信息
	 */
	protected function setError($errmsg)
	{
		$this->errmsg = $errmsg;
	}
}

