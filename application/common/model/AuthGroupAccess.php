<?php
// +----------------------------------------------------------------------
// | 用户-角色关联模型
// +----------------------------------------------------------------------
// | @copyright (c) dorisnzy.com All rights reserved.
// +----------------------------------------------------------------------
// | @author: dorisnzy <dorisnzy@163.com>
// +----------------------------------------------------------------------
// | @version: v1.0
// +----------------------------------------------------------------------

namespace app\common\model;
use app\common\model\Model;

class AuthGroupAccess extends Model
{
	//设置数据表（不含前缀)
    protected $name = 'auth_group_access';
}