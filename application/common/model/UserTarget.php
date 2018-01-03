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
 * 目的地商家用户模型
 */
class UserTarget extends Model
{
	//设置数据表（不含前缀)
    protected $name = 'user_target';
    // 数据表主键 复合主键使用数组定义 不设置则自动获取
    protected $pk = 'target_id';

    // 会员关联模型
    public function user()
    {
    	return $this->belongsTo('user', 'uid');
    }
}