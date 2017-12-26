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
 * 权限验证器
 */
class Rule extends Validate
{
	protected $rule = array(
		'title'      => 'require',
		'module'   => 'require',
		'controller'     => 'require',
		'node'     => 'require',
		'group'     => 'require',
		'name'     => 'require|unique:auth_rule',
	);
	protected $message = array(
		'title.require'    => '请选择上级菜单',
		'title.require'    => '请填写标题',
		'module.require'    => '模块不能为空',
		'controller.require'    => '请填写控制器',
		'node.require'    => '请填写方法',
		'group.require'    => '请选择菜单分组',
		'name.require'    => '权限出错',
		'name.unique'    => '权限节点冲突',
	);
	protected $scene = array(
		'add' => 'title,module,controller,node,group,name',
		'edit' => 'title,module,controller,node,group,name',
	);
}
