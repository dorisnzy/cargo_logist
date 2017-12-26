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
	protected $userInfo;
	/**
	 * 系统初始化
	 *
	 * @return void
	 */
	protected function _initialize()
	{
		$this->userInfo = model('User')->getCurrentUserInfo();

		// 获取当前访问地址
        $current_url = $this->request->path();

        //不需要权限检测链接数组
        $_noaccess_url_arr = array('admin/user/login', 'admin/user/logout', 'admin/user/verify',);
        if (!is_login() && !in_array($current_url, $_noaccess_url_arr)) {
			$this->redirect('admin/user/login');
		}

		//不是管理员禁止登陆后台
        if(!$this->userInfo['isadministrator'] && !in_array($current_url, $_noaccess_url_arr)){
        	model('User')->logout();
            $this->error('您不是管理员，非法访问','admin/index/login');
        }

        // 是否是超级管理员
		defined('IS_ROOT') or define('IS_ROOT', is_administrator());

		if (!in_array($current_url, $_noaccess_url_arr)) {
            
            // 检测系统权限
			if (!IS_ROOT) {
                $access = $this->accessControl();
                if (false === $access) {
					$this->error('403:禁止访问');
				} elseif (null === $access) {
					$dynamic = $this->checkDynamic(); //检测分类栏目有关的各项动态权限
					if ($dynamic === null && !in_array($current_url, $_noaccess_url_arr)) {
						//检测访问权限
						if (!$this->checkRule($current_url, array('in', '1,2'))) {
							model('User')->logout();
							$this->error('未授权访问!');
						} else {
							// 检测分类及内容有关的各项动态权限
							$dynamic = $this->checkDynamic();
							if (false === $dynamic) {
								model('User')->logout();
								$this->error('未授权访问!');
							}
						}
					} elseif ($dynamic === false) {
						model('User')->logout();
						$this->error('未授权访问!');
					}
				}
			}
        }
        
        //菜单设置
        $this->assign("__MENU__", $this->getMenus());



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
	public function getMenus()
	{
		// 获取当前访问地址
        $current_url = $this->request->path();

        // 获取顶级主菜单
        $main_map['pid'] = 0;
        $main_map['module'] = 'admin';
        $main_map['status'] = 1;
      	$main_map['type'] = 1;

      	$main_list = db('menu')->where($main_map)->order('sort asc,id asc')->select();
      	foreach ($main_list as $key => $item) {
      		//此处用来做权限判断
			if (!IS_ROOT && !$this->checkRule($item['name'])) {
				unset($menus['main'][$item['id']]);
				continue; //继续循环
			}

      		if ($current_url == $item['name']) {
      			$item['class'] = 'layui-this';
      		} else {
      			$item['class'] = '';
      		}

      		$menus['main'][$item['id']] = $item;
      	}

      	//查询当前的父菜单id和菜单id
        $pid = db('menu')->where("pid !=0 AND name = '{$current_url}' AND status = 1")->value('pid');
        $id  = db('menu')->where("pid = 0 AND name = '{$current_url}' AND status = 1")->value('id');

        $pid = $pid ? $pid : $id;

        if (!$pid) {
        	return $menus;
        }

        $sub_map['pid']  = $pid;
        $sub_map['type'] = 2;
        $sub_map['status'] = 1;

        $sub_row = db('menu')->where($sub_map)->order('sort asc,id asc')->select();

        $current_id  = db('menu')->where(array('status'=>1,'name'=>$current_url))->value('pid');

        foreach ($sub_row as $key => $item) {
        	if (IS_ROOT || $this->checkRule($value)) {
        		$menus['main'][$item['pid']]['class'] = 'layui-this';

        		if ($current_url == $item['name']) {
        			$item['class'] = 'layui-this';
        			$menus['_child'][$item['group']]['class'] = 'layui-nav-itemed';
        		} else {
        			$item['class'] = '';
        		}

        	} else if ($current_id == $item['id']) {
        		$menus['main'][$item['pid']]['class'] = 'layui-this';
        		
        		if ($current_url == $item['name']) {
        			$item['class'] = 'layui-this';
        			$menus['_child'][$item['group']]['class'] = 'layui-nav-itemed';
        		} else {
        			$item['class'] = '';
        		}
        	} else {
        		$item['class'] 						  = '';
        	}

        	$menus['_child'][$item['group']]['item'][$key] = $item;
        }
        // halt($menus);
        return $menus;
	}

	/**
	 * 设置meta_title
	 *
	 * @author dorisnzy <dorisnzy@163.com>
	 *
	 * @param  string $meta_title 标题信息
	 */
	protected function setMeta($meta_title = '')
	{
		$this->assign('meta_title', $meta_title);
	}

	/**
	 * 检测是否是需要动态判断的权限
	 * @return boolean|null
	 *      返回true则表示当前访问有权限
	 *      返回false则表示当前访问无权限
	 *      返回null，则表示权限不明
	 *
	 */
	protected function checkDynamic()
	{
		if (IS_ROOT) {
			return true; //管理员允许访问任何页面
		}
		return null; //不明,需checkRule
	}

	/**
	 * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
	 *
	 * @return boolean|null  返回值必须使用 `===` 进行判断
	 *
	 *   返回 **false**, 不允许任何人访问(超管除外)
	 *   返回 **true**, 允许任何管理员访问,无需执行节点权限检测
	 *   返回 **null**, 需要继续执行节点权限检测决定是否允许访问
	 */
	final protected function accessControl()
	{
		// $allow = \think\Config::get('allow_visit');
  //       $deny  = \think\Config::get('deny_visit');
  //       $check = strtolower($this->request->controller() . '/' . $this->request->action());
  //       if (!empty($deny) && !empty($deny) && in_array_case($check, $deny)) {
  //           return false; //非超管禁止访问deny中的方法
  //       }
  //       $allow = explode(':', $allow);
		// if (!empty($allow) && in_array_case($check, $allow)) {
		// 	return true;
		// }
		return null; //需要检测节点权限
	}

	/**
	 * 权限检测
	 * @param string  $rule    检测的规则
	 * @param string  $mode    check模式
	 * @return boolean
	 */
	final protected function checkRule($rule, $type = 1, $mode = 'url')
	{
		static $Auth = null;
		if (!$Auth) {
			$Auth = new \app\common\org\Auth();
		}

		if (!$Auth->check($rule, session('user_auth.uid'), $type, $mode)) {
			return false;
		}
		return true;
	}

	/**
	 * 删除数据
	 *
	 * @return void 
	 */
	public function delete()
	{	
		$data = input('param.');

		if (empty($data['model'])) {
			return $this->error('请指定模型');
		}

		$model = $data['model'];

		$pk = model($model)->getPk();

		if (empty($data[$pk])) {
			return $this->error('参数错误');
		}

		$map[$pk] = $data[$pk];

		$res = model($model)->where($map)->delete();

		if (!$res) {
			return $this->error('删除失败');
		}

		// 关联数据删除
		if (empty($data['link_model'])) {
			return $this->success('删除成功');
		}

		model($data['link_model'])->where($map)->delete();
		
		return $this->success('删除成功');

	}
}