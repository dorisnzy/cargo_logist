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
 * 菜单控制器
 */
class Menu extends Base
{
	// 用户模型
    protected $modelMenu;

	/**
	 * 后台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelMenu = model('Menu');
		$this->setMeta('菜单管理');

		// 获取菜单列表
		$curr_action = ['add', 'edit'];
		if (in_array($this->request->action(), $curr_action) && !$this->request->isAjax()) {
			$module = input('param.module', 'admin');

			// 获取菜单
			$map['status'] = 1;
			$map['module'] = $module ;
			$list  = $this->modelMenu->where($map)->field(true)->order('sort asc,id asc')->column('*', 'id');
			if ($list) {
				$tree = new \app\common\org\TreeList();
				$list = $tree->toFormatTree($list);
			}

			// 获取菜单分组
			$menu_gorup = config('menu_gorup');

			$this->assign('list', $list);
			$this->assign('module', $module);
			$this->assign('menu_gorup', $menu_gorup);
		}
	}

	/**
	 * 菜单列表
	 */
	public function index($module = 'admin')
	{
		if ($this->request->isAjax()) {

			$map = [];
			$map['status'] = ['egt', 0];
			$map['module'] = $module;

			$list  = $this->modelMenu->where($map)->field(true)->order('sort asc,id asc')->column('*', 'id');

			if ($list) {
				$tree = new \app\common\org\TreeList();
				$list = $tree->toFormatTree($list);
			}

			$this->assign('list', $list);
			$this->assign('module', $module);
			$html = $this->fetch('index_ajax');
			return $this->success('获取成功', '', ['list' => $html]);
		}
		return $this->fetch();
	}

	/**
	 * 新增菜单
	 */
	public function add($pid = 0, $module = 'admin')
	{
		if ($this->request->isPost()) {
			$data = input('post.');

			$vali_res = $this->validate($data, 'Menu.add');
			if ($vali_res !== true) {
				return $this->error($vali_res);
			}

			$data['name'] = $data['module'] . '/' . $data['controller'] . '/' . $data['node'];
			unset($data['controller']);
			unset($data['node']);

			$res = $this->modelMenu->save($data);

			if ($res) {
                return $this->success('新增成功', url('index'));
            }

			return $this->error($this->modelMenu->getError(), '');
		}

		$info['pid'] = $pid;
		$info['module'] = $module;
		$this->assign('info', $info);

		return $this->fetch('edit');
	}

	/**
	 * 编辑菜单
	 */
	public function edit($id = 0)
	{
		$info = $this->modelMenu->where('id', $id)->find();
		if (!$info) {
			return $this->error('信息不存在');
		}

		if ($this->request->isPost()) {
			$data = input('post.');

			$vali_res = $this->validate($data, 'Menu.edit');
			if ($vali_res !== true) {
				return $this->error($vali_res);
			}

			$data['name'] = $data['module'] . '/' . $data['controller'] . '/' . $data['node'];
			unset($data['controller']);
			unset($data['node']);

			$res = $this->modelMenu->where('id', $info['id'])->update($data);

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
		return $this->fetch();
	}
}
