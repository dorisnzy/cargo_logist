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

use app\admin\controller\Base;

/**
 * 商家控制器
 */
class Merchant extends Base
{
	// 用户模型
    protected $modelMerchant;

	/**
	 * 后台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelMerchant = model('Merchant');
	}

	/**
	 * 列表信息
	 */
	public function index($type = 1)
	{
        $map['type'] = $type;

        // 名称
        if ($this->request->param('name')) {
            $map['name'] = ['like', '%'. $this->request->param('name') . '%'];
        }

        if ($this->request->isAjax()) {
            $count = $this->modelMerchant->where($map)->count();

            $list  = $this->modelMerchant
                ->where($map)
                ->page($this->modelMerchant->getPageNow(), $this->modelMerchant->getPageLimit())
                ->order('merchant_id desc')
                ->select()
            ;

            if (!$list) {
                return $this->error('信息不存在');
            }

            $this->assign('list', $list);
            $html = $this->fetch('index_ajax');

            $data = [
                'list'  => $html,
                'count' => $count,
                'limit' => $this->modelMerchant->getPageLimit()
            ];

            return $this->success('获取成功', '', $data);
        }
        $this->assign('type', $type);
        $this->setMeta('用户列表');
		return $this->fetch();
	}

	/** 
	 * 新增
	 */
	public function add($type = 1)
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			$data['type'] = $type;

			$res = $this->modelMerchant->save($data);
			if (!$res) {
				return $this->error('新增失败');
			}
			return $this->success('新增成功', url('index', ['type' => $type]));
		}

		$this->setMeta('新增');
		return $this->fetch('edit');
	}

	/**
	 * 编辑
	 */
	public function edit($merchant_id = 0)
	{
		$map['merchant_id'] = $merchant_id;

		$info = $this->modelMerchant->where($map)->find();
		if (!$info) {
			return $this->error('信息不存在');
		}

		if ($this->request->isPost()) {
			$data = $this->request->post();

			$res = $this->modelMerchant->where($map)->update($data);
			if ($res === false) {
				return $this->error('新增失败');
			}
			return $this->success('编辑成功', 'index');
		}

		$this->setMeta('编辑');

		$this->assign('info', $info);
		return $this->fetch('edit');
	}

	/**
	 * 选择用户
	 */
	public function selUser($merchant_id = 0, $type = 1)
	{
		$map['merchant_id'] = $merchant_id;

		$info = $this->modelMerchant->where($map)->find();
		if (!$info) {
			return $this->error('信息不存在');
		}

		if ($this->request->isPost()) {
			$data = $this->request->post();

			if (empty($data['uid'])) {
				$user_map['uid'] = 0;
			} else {
				$user_map['uid'] = ['in', $data['uid']];
			}

			switch ($type) {
				// 供应商
				case 1 :
					$model = db('user_supplier');
					break;
				// 目的地商家
				case 2 :
					$model = db('user_target');
					break;
				default :
					return $this->error('非法访问');
			}

			// 商家员工重置
			$res = $model
				->where(['merchant_id' => $info['merchant_id']])
				->update(['merchant_id' => 0])
			;

			// 选择员工
			$res = $model->where($user_map)->update(['merchant_id' => $info['merchant_id']]);
			if ($res === false) {
				return $this->error('选择失败');
			}
			return $this->success('选择成功', 'index');
		}

		// 获取商家用户
		switch ($type) {
			// 供应商
			case 1 :
				$user_map['u.type'] = 2;
				$db_name = '__USER_SUPPLIER__';
				$model = db('user_supplier');
				break;
			// 目的地商家
			case 2 :
				$user_map['u.type'] = 5;
				$db_name = '__USER_TARGET__';
				$model = db('user_target');
				break;
			default :
				return $this->error('非法访问');
		}
		$user_map['m.merchant_id'] = 0;
		$list = db('user')
			->alias('u')
			->field('u.uid,u.realname')
			->join($db_name . ' m', 'u.uid = m.uid')
			// ->where($user_map)
			->order('m.merchant_id desc')
			->select()
		;
		if (!$list) {
			return $this->error('没有用户供选择');
		}

		// 获取我已经选择的员工
		$my_uid = $model
			->where(['merchant_id' => $info['merchant_id']])
			->column('uid')
		;

		$this->assign('my_uid', implode(',', $my_uid));
		$this->assign('list', $list);
		$this->setMeta('选择用户');

		$this->assign('info', $info);
		return $this->fetch();
	}
}