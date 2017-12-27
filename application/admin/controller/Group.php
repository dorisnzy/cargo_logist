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
 * 角色控制器
 */
class Group extends Base
{
	// 用户模型
    protected $modelGroup;

	/**
	 * 后台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelGroup = model('AuthGroup');
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

        if ($this->request->isAjax()) {
            $count = $this->modelGroup->where($map)->count();

            $list  = $this->modelGroup
                ->where($map)
                ->page($this->modelGroup->getPageNow(), $this->modelGroup->getPageLimit())
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
                'limit' => $this->modelGroup->getPageLimit()
            ];

            return $this->success('获取成功', '', $data);
        }

        $this->setMeta('列表信息');
		return $this->fetch();
	}
	
	/** 
	 * 新增
	 */
	public function add()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();

			$res = $this->modelGroup->save($data);
			if (!$res) {
				return $this->error('新增失败');
			}
			return $this->success('新增成功', 'index');
		}

		$this->setMeta('新增');
		return $this->fetch('edit');
	}

	/**
	 * 编辑
	 */
	public function edit($group_id = 0)
	{
		$map['id'] = $group_id;

		$info = $this->modelGroup->where($map)->find();
		if (!$info) {
			return $this->error('用户信息不存在');
		}

		if ($this->request->isPost()) {
			$data = $this->request->post();

			$res = $this->modelGroup->where($map)->update($data);
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
	 * 授权
	 */
	public function auth($module = 'admin', $group_id = 0)
	{
		$info = $this->modelGroup->where('id', $group_id)->find();
		if (!$info) {
			return $this->error('组别不存在');
		}

		if ($this->request->isPost()) {
			$rules = input('post.rules/a', []);

			$data['rules'] = implode(',', $rules);

			$map['id'] = $group_id;

			$res = $this->modelGroup->where($map)->update($data);

			if ($res === false) {
				return $this->error('授权失败');
			}

			return $this->success('授权成功', 'index');
		}

		// 获取权限列表信息
		$map['module'] = $module;
		$map['status'] = 1;
		$list = model('AuthRule')->field('id,title,group')->where($map)->select();

		// 按组别整理权限
		$res = [];
		foreach ($list as $key => $item) {
			$res[$item['group']][$key]['id']   = $item['id'];
			$res[$item['group']][$key]['title'] = $item['title'];
		}

		// 获取权限组
		$auth_group = config('auth_group');

		$this->assign('auth_group', $auth_group);
		$this->assign('module', $module);
		$this->assign('list', $res);
		$this->assign('info', $info);

		$this->setMeta('授权');

		return $this->fetch();
	}
}