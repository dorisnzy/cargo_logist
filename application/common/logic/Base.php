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
	// 基础配置
	protected $config;

	/**
	 * 获取错误信息
	 */
	public function getError(){
		return $this->errmsg;
	}

	public function __construct()
	{
		parent::__construct();
		$this->logicInit();
	}

	// 初始化
	protected function logicInit(){}

	/**
	 * 设置错误信息
	 */
	protected function setError($errmsg)
	{
		$this->errmsg = $errmsg;
	}

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
	 * 获取配置信息
	 */
	public function getConfig($key)
	{
		if (!empty($this->config[$key])) {
			return $this->config[$key];
		}
		return false;
	}
}

