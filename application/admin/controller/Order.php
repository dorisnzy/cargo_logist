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
use app\common\logic\Order as LogicOrder;

/**
 * 供应商发布需求订单控制器
 */
class Order extends Base
{
	/**
	 * 前台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelOder = model('Order');
		$this->modelOrderLog = model('OrderLog');
		$this->logicOrder = new LogicOrder;
	}

	/**
	 * 供应商发布需求列表信息
	 */
	public function index()
	{
        $map = ['order_status' => 0];

        if ($this->request->isAjax()) {
            $count = $this->modelOder->where($map)->count();

            $list  = $this->modelOder
                ->where($map)
                ->page($this->modelOder->getPageNow(), $this->modelOder->getPageLimit())
                ->order('publish_time desc')
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
                'limit' => $this->modelOder->getPageLimit()
            ];

            return $this->success('获取成功', '', $data);
        }

        $this->setMeta('供应商发布需求列表');
		return $this->fetch();
	}

	/**
	 * 指派取货
	 */
	public function designateTake($order_id = 0)
	{
		$map['order_id'] = $order_id;
		$info = $this->modelOder->where($map)->find();

		if (!$info) {
			return $this->error('订单不存在');
		}

		if ($info['order_status'] >= 20) {
			return $this->error('已经指派过');
		}

		if ($this->request->isPost()) {
			$param = input('post.');
			if (!isset($param['take_uid'])) {
				return $this->error('请选择取货人');
			}

			$data['take_uid'] = $param['take_uid'];
			$data['take_time'] = time();
			$data['order_status'] = 20;

			$res = $this->modelOder->where($map)->update($data);
			if ($res === false) {
				return $this->error('确认有误');
			}

			// 添加订单日志-----指派取货人成功
			$log_data['order_id'] = $order_id;
			$log_data['order_status'] = 20;
			$log_data['op_uid']  = $this->userInfo['uid'];
			$log_data['log_time'] = time();
			$log_data['log_msg'] = '发布成功，平台收到待分配取货者';

			$res = $this->logicOrder->setConfig($log_data)->addOrderLog();

			if ($res === false) {
				$data['order_status'] = $info['order_status'];
				$this->modelOder->where($map)->update($data);
				return $this->error('指派有误');
			}

			// 修改取货者工作状态
			model('UserTake')->where(['uid' => $data['take_uid']])->update(['work_status' => 1]);

			return $this->success('指派成功');
		}

		// 获取空闲取货者列表信息
		$list = model('UserTake')->where(['work_status' => 0])->select();
		if (!$list) {
			return $this->error('没有取货者或者取货者全部都在忙');
		}

		$this->assign('list', $list);
		$this->assign('info', $info);

		$html = $this->fetch('designate_take_ajax');
		return $this->success('获取成功', '', ['html' => $html]);
	}
}