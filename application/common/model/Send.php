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
 * 司机送货订单模型
 */
class Send extends Model
{
	//设置数据表（不含前缀)
    protected $name = 'Send';
    // 数据表主键 复合主键使用数组定义 不设置则自动获取
    protected $pk = 'send_id';

    // 供货商关联模型
    public function merchant()
    {
   		return $this->belongsTo('merchant', 'merchant_id');
    }

    // 供应商用户关联模型
    public function supplier()
    {
    	return $this->belongsTo('user', 'supplier_uid');
    }

    // 供应商发布需求订单关联模型
    public function order()
    {
    	return $this->belongsTo('order', 'order_id');
    }

    // 司机用户关联模型
    public function driver()
    {
    	return $this->belongsTo('user', 'driver_uid');
    }
}