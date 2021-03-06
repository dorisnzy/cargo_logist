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

namespace app\common\model;
use app\common\model\Model;

/**
 * 权限模型
 */
class AuthRule extends Model
{
	//设置数据表（不含前缀)
    protected $name = 'auth_rule';
    // 数据表主键 复合主键使用数组定义 不设置则自动获取
    protected $pk = 'id';

    // 保存自动完成列表
    protected $auto = ['type'];

    protected function setTypeAttr($value, $data)
    {
    	return $data['group'] == '顶级菜单' ? 2 : 1;
    } 
}