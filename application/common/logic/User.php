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
 * 用户服务逻辑层
 */
class User extends Base
{
	// 模型组
	protected $modelObj = [];

	// 初始化
	protected function logicInit()
	{
		$this->modelObj['admin'] 	= model('UserAdmin');
		$this->modelObj['driver'] 	= model('UserDriver');
		$this->modelObj['supplier'] = model('UserSupplier');
		$this->modelObj['target'] 	= model('UserTarget');
		$this->modelObj['take'] 	= model('UserTake');
	}

	/**
	 * 添加用户类型
	 */
	public function addTypeUser()
	{
		// 删除该用户原有的数据
		$map = ['uid' => $this->config['uid']];
		foreach ($this->modelObj as $key => $obj) {
			$obj->where($map)->delete();
		}

		// 重置角色
		$group_id = model('AuthGroup')
			->where(['type' => $this->config['type']])
			->value('id')
		;
		model('AuthGroupAccess')->addLink($this->config['uid'], [$group_id]);
		
		// 添加用户
		switch ($this->config['type']) {
			// 后台管理员
			case 1 :
				return $this->addAdmin();
				break;
			// 供应商用户
			case 2 :
				return $this->addSupplier();
				break;
			// 取货者用户
			case 3 :
				return $this->addTake();
				break;
			// 司机用户
			case 4 :
				return $this->addDriver();
				break;
			// 目的地商家用户
			case 5 :
				return $this->addTarget();
				break;
		}
	}

	/**
	 * 添加管理员
	 *
	 * @return boolean  成功-true，失败-false
	 */
	public function addAdmin()
	{
		$data['uid'] = $this->config['uid'];
		$res = $this->modelObj['admin']->save($data);
		if (!$res) {
			$this->setError('添加管理员失败');
			return false;
		}

		return true;
	}

	/**
	 * 添加供应商用户
	 *
	 * @return boolean  成功-true，失败-false
	 */
	public function addSupplier()
	{
		$data['uid'] = $this->config['uid'];
		$res = $this->modelObj['supplier']->save($data);
		if (!$res) {
			$this->setError('添加供应商用户失败');
			return false;
		}

		return true;
	}

	/**
	 * 添加取货者用户
	 *
	 * @return boolean  成功-true，失败-false
	 */
	public function addTake()
	{
		$data['uid'] = $this->config['uid'];
		$res = $this->modelObj['take']->save($data);
		if (!$res) {
			$this->setError('添加取货者失败');
			return false;
		}

		return true;
	}

	/**
	 * 添加司机用户
	 *
	 * @return boolean  成功-true，失败-false
	 */
	public function addDriver()
	{
		$data['uid'] = $this->config['uid'];
		$res = $this->modelObj['driver']->save($data);
		if (!$res) {
			$this->setError('添加司机失败');
			return false;
		}

		return true;
	}

	/**
	 * 添加目的地商家用户
	 *
	 * @return boolean  成功-true，失败-false
	 */
	public function addTarget()
	{
		$data['uid'] = $this->config['uid'];
		$res = $this->modelObj['target']->save($data);
		if (!$res) {
			$this->setError('添加目的地商家用户失败');
			return false;
		}

		return true;
	}

	/**
	 * 检查各类型用户是否存在
	 *
	 * @param object  $model  各类型用户模型
	 */
	public function checkTypeUser($model)
	{
		$map['uid'] = $this->config['uid'];
		$info = $model->where($map)->find();
		if (!$info) {
			$this->setError('该类型用户不存在');
			return false;
		}

		return $info;
	}
}

