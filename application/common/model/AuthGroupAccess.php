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

    /**
     * 添加用户组-用户关联关系
     *
     * @param integer $uid      用户ID
     * @param array $group_id 用户组ID
     */
    public function addLink($uid, $group_id)
    {
    	$this->where(['uid' => $uid])->delete();

    	if (!$group_id) {
    		return false;
    	}

    	foreach ($group_id as $key => $id) {
    		$group_data[$key]['uid'] = $uid;
    		$group_data[$key]['group_id'] = $id;
    	}
    	
    	return $this->insertAll($group_data);
    }
}