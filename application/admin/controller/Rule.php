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
 * 权限控制器
 */
class Rule extends Base
{
	// 用户模型
    protected $modelRule;

	/**
	 * 后台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelRule = model('AuthRule');
		$this->setMeta('权限管理');

		// 获取权限组
		$curr_action = ['add', 'edit'];
		if (in_array($this->request->action(), $curr_action) && !$this->request->isAjax()) {
			$module = input('param.module', 'admin');
			$group = config('auth_group.'. $module);
			$this->assign('group', $group);
		}
	}

	/** 
	 * 列表信息
	 */
	public function index()
	{
		$map = [];
        
        // 按标题搜索
        if ($this->request->param('title')) {
            $map['title'] = ['like', '%'. $this->request->param('title') . '%'];
        }

        // 标识搜索
        if ($this->request->param('name')) {
            $map['name'] = ['like', '%'. $this->request->param('name') . '%'];
        }

        // 权限组搜索
         if ($this->request->param('group')) {
            $map['group'] = $this->request->param('group');
        }

        if ($this->request->isAjax()) {
            $count = $this->modelRule->where($map)->count();

            $list  = $this->modelRule
                ->where($map)
                ->page($this->modelRule->getPageNow(), $this->modelRule->getPageLimit())
                ->order('id desc')
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
                'limit' => $this->modelRule->getPageLimit()
            ];

            return $this->success('获取成功', '', $data);
        }

        $group = config('auth_group');
		$this->assign('group', $group);

		return $this->fetch();
	}

	/**
	 * 新增
	 */
	public function add($module = 'admin')
	{
		if ($this->request->isPost()) {
			$data = input('post.');
			$data['name'] = $data['module'] . '/' . $data['controller'] . '/' . $data['node'];

			$vali_res = $this->validate($data, 'Rule.add');
			if ($vali_res !== true) {
				return $this->error($vali_res);
			}

			unset($data['controller']);
			unset($data['node']);

			$res = $this->modelRule->save($data);

			if ($res) {
                return $this->success('新增成功', url('index'));
            }

			return $this->error($this->modelRule->getError(), '');
		}

		$info['module'] = $module;
		$this->assign('info', $info);

		return $this->fetch('edit');
	}

	/**
	 * 编辑
	 */
	public function edit($id = 0)
	{
		$info = $this->modelRule->where('id', $id)->find();
		if (!$info) {
			return $this->error('信息不存在');
		}

		if ($this->request->isPost()) {
			$data = input('post.');
			$data['name'] = $data['module'] . '/' . $data['controller'] . '/' . $data['node'];
			$data['id'] = $info['id'];

			$vali_res = $this->validate($data, 'Rule.edit');
			if ($vali_res !== true) {
				return $this->error($vali_res);
			}

			unset($data['controller']);
			unset($data['node']);

			$res = $this->modelRule->where('id', $info['id'])->update($data);

			if ($res === false) {
            	return $this->error('编辑失败');
            }

            return $this->success('编辑成功', url('index'));
		}

		list($module, $controller, $node) = explode('/', $info->name);
		$info->module     = $module;
		$info->controller = $controller;
		$info->node       = $node;

		$this->assign('info', $info);
		return $this->fetch('edit');
	}
}