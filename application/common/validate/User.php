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
 * 用户验证器
 */
class User extends Validate
{
	protected $rule = array(
		'username'   => 'require|unique:user|/^[a-zA-Z]\w{0,39}$/',
		'email'      => 'require|unique:user|email',
		'mobile'     => 'unique:user',
		'weixin'     => 'unique:user',
		'password'   => 'require',
		'repassword' => 'confirm:password',
	);
	protected $message = array(
		'username.require'    => '用户名必须输入',
		'username.unique'    => '用户名已存在',
		'email.require'    => '邮箱必须',
		'email.unique'    => '邮箱已存在',
		'mobile.unique'    => '手机号已存在',
		'password.require' => '密码必须',
		'repassword.require'    => '确认密码和密码必须一致',
	);
	protected $scene = array(
		'add'     => 'email,mobile,username,weixin',
		'edit'     => 'email,mobile,username,weixin',
		'password' => 'password,repassword',
	);
}
