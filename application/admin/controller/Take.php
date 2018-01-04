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
 * 取货员控制器
 */
class Take extends Base
{
	// 用户模型
    protected $modelTake;

	/**
	 * 后台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelTake = model('UserTake');
	}

	/**
	 * 列表信息
	 */
	public function index()
	{
        $map = [];
        // 关键词搜索
        if ($this->request->param('keyword')) {
            $map['u.nickname|u.username|u.email|u.mobile|u.realname'] = [
                'like', 
                '%'. $this->request->param('keyword') . '%'
            ];
        }

        if ($this->request->isAjax()) {
            $count = $this->modelTake
                ->alias('t')
                ->where($map)->join('__USER__ u', 'u.uid=t.uid')
                ->count()
            ;

            $list  = $this->modelTake
                ->alias('t')
                ->join('__USER__ u', 'u.uid=t.uid')
                ->where($map)
                ->page($this->modelTake->getPageNow(), $this->modelTake->getPageLimit())
                ->order('t.uid desc')
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
                'limit' => $this->modelTake->getPageLimit()
            ];

            return $this->success('获取成功', '', $data);
        }

        $this->setMeta('取货员列表');
		return $this->fetch();
	}

    /**
     * 修改工作状态
     */
    public function updateWorkStatus($uid = 0)
    {
        $info = $this->modelTake->where('uid', $uid)->find();
        if (!$info) {
            return $this->error('信息不存在');
        }

        if ($this->request->isPost()) {
            $data = input('post.');
            if (!isset($data['work_status'])) {
                return $this->error('非法操作');
            }
            $res = $this->modelTake->where('uid', $uid)->update(['work_status' => $data['work_status']]);
            if ($res === false) {
                return $this->error('修改失败');
            }
            return $this->success('修改成功', 'index');
        }

        $this->assign('info', $info);
        $this->assign('uid', $uid);
        $html = $this->fetch('work_status_ajax');
        return $this->success('获取成功', '', ['html' => $html]);
    }
}