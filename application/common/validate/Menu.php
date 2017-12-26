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

namespace app\common\validate;

use think\Validate;

/**
 * 菜单验证器
 */
class Menu extends Validate
{
	protected $rule = array(
		'pid'      => 'require',
		'title'      => 'require',
		'module'   => 'require',
		'controller'     => 'require',
		'node'     => 'require',
		'group'     => 'require',
		'type'   => 'require|in:1,2',
	);
	protected $message = array(
		'title.require'    => '请选择上级菜单',
		'title.require'    => '请填写标题',
		'module.require'    => '模块不能为空',
		'controller.require'    => '请填写控制器',
		'node.require'    => '请填写方法',
		'group.require'    => '请选择菜单分组',
		'type.require'    => '请选择菜单类型',
		'type.in'    => '菜单类型格式不正确',
	);
	protected $scene = array(
		'add' => 'pid,title,module,controller,node,group,type',
		'edit' => 'pid,title,module,controller,node,group,type',
	);
}
