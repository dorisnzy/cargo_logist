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
	// 当前用户信息
	protected $userInfo;
	// 当前url
	protected $currentUrl;

	// 不需要验证权限的节点
	protected $noaccessUrlArr = [
		'admin/user/login', 
		'admin/user/logout', 
		'admin/user/verify',
		'admin/index/index',
	];

	/**
	 * 系统初始化
	 *
	 * @return void
	 */
	protected function _initialize()
	{
		$this->userInfo = model('User')->getCurrentUserInfo();

		// 获取当前访问地址
        $this->currentUrl  = $this->request->module() . '/';
		$this->currentUrl .= $this->request->controller() . '/';
		$this->currentUrl .= $this->request->action();
		
		$this->currentUrl  = strtolower($this->currentUrl);
        
        //不需要权限检测链接数组
        if (!is_login() && !in_array($this->currentUrl, $this->noaccessUrlArr)) {
			$this->redirect('admin/user/login');
		}

        // 是否是超级管理员
		defined('IS_ROOT') or define('IS_ROOT', is_administrator());

		//不是后台管理员禁止登陆后台
        if(!IS_ROOT && $this->userInfo['type'] != 1 && !in_array($this->currentUrl, $this->noaccessUrlArr)){
        	model('User')->logout();
            $this->error('您不是管理员，非法访问','admin/index/login');
        }



		if (!in_array($this->currentUrl, $this->noaccessUrlArr)) {            
            // 检测系统权限
			if (!IS_ROOT) {
				// 检测控制访问权限（这一级权限为系统最高权限验证）
                $access = $this->accessControl();
                if (-1 === $access) {
                	$this->error('403:禁止访问');
                }

                //检测访问权限
                if (!$this->checkRule($this->currentUrl, array('in', '1,2'))) {
                	$this->error('未授权访问!');
                }
			}
        }
        
        //菜单设置
        if (!$this->request->isAjax()) {
        	$this->assign('USER_INFO', $this->userInfo);
        	$this->assign("__MENU__", $this->getMenus());
        }

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
        // 获取顶级主菜单
        $main_map['pid'] = 0;
        $main_map['module'] = 'admin';
        $main_map['status'] = 1;
      	$main_map['type'] = 1;

      	$menus = [];

      	$main_list = db('menu')
      		->where($main_map)
      		->order('sort asc,id asc')
      		->select()
      	;
      	foreach ($main_list as $key => $item) {
      		// 获取子菜单标识
      		$sub_tag = db('menu')
      			->where(['pid' => $item['id']])
      			->value('id')
      		;
      		
			// 没有子菜单 并且 不在公开节点内
			if (!in_array($item['name'], $this->noaccessUrlArr)) {
				// 不是超级管理员进行权限验证
				if (!IS_ROOT && !$this->checkRule($item['name'], 2)) {
					continue; //继续循环
				}
			}

      		if ($this->currentUrl == $item['name']) {
      			$item['class'] = 'layui-this';
      		} else {
      			$item['class'] = '';
      		}

      		$menus['main'][$item['id']] = $item;
      	}

      	//查询当前的父菜单id和菜单id
      	$node = explode('/', $this->currentUrl);
      	$hover_url = $node[0].'/'.$node[1];

        $pid = db('menu')
        	->where("pid !=0 AND name like '{$hover_url}%' AND status = 1")
        	->value('pid')
        ;
        $id  = db('menu')
        	->where("pid = 0 AND name like '{$hover_url}%' AND status = 1")
        	->value('id')
        ;

        $pid = $pid ? $pid : $id;

        if (!$pid) {
        	return $menus;
        }

        $sub_map['pid']  = $pid;
        $sub_map['type'] = 2;
        $sub_map['status'] = 1;

        $sub_row = db('menu')
        	->where($sub_map)
        	->order('sort asc,id asc')
        	->column('*', 'id')
        ;

        if (!$sub_row) {
        	return $menus; //如果没有子菜单直接返回
        }

        $current_id  = db('menu')
        	->where(array('status'=>1,'name'=>$this->currentUrl))
        	->value('pid')
        ;

        $sub_pid = db('menu')
        	->where("pid !=0 AND name like '{$hover_url}%' AND status = 1")
        	->value('id')
        ;

    	// 给当前左侧子菜单激活属性
        $sub_row[$sub_pid]['class'] = 'layui-this';
    	// 给当前左侧菜单组激活属性
    	$menus['_child'][$sub_row[$sub_pid]['group']]['class'] = 'layui-nav-itemed';
    	if (!empty($menus['main'][$sub_row[$sub_pid]['pid']])) {
    		$menus['main'][$sub_row[$sub_pid]['pid']]['class'] = 'layui-this';
    	}

        // 给主菜单激活属性
        foreach ($sub_row as $key => $item) {
        	// 不在公开节点内
			if (!in_array($item['name'], $this->noaccessUrlArr)) {
				// 不是超级管理员进行权限验证
				if (!IS_ROOT && !$this->checkRule($item['name'], 1)) {
					continue; //继续循环
				}
			}

        	$menus['_child'][$item['group']]['item'][$key] = $item;
        }

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
		// $this->assign('meta_title', $meta_title);
		// 
		if ($this->request->isAjax()) {
			return false;
		}

		$node = explode('/', $this->currentUrl);
      	$hover_url = $node[0].'/'.$node[1];

		$sub_title = db('menu')
			->field('pid,title,name')
			->where("pid !=0 AND name like '{$hover_url}%' AND status = 1")
			->find();
		;

        $main_title  = db('menu')
        	->field('pid,title,name')
        	->where('id', $sub_title['pid'])
        	->find();
        ;

        $nav['main'] = $main_title;
        $nav['sub'] = $sub_title;
        $nav['current'] = $meta_title;

        $this->assign('__NAV__', $nav);
	}

	/**
	 * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
	 *
	 * @return boolean|null  返回值必须使用 `===` 进行判断
	 *
	 *   返回 **-1**, 不允许任何人访问(超管除外)
	 *   返回 **1**, 允许任何管理员访问,无需执行节点权限检测
	 *   返回 **0**, 需要继续执行节点权限检测决定是否允许访问
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
		return 0; //需要检测节点权限
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