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
 * 用户模型
 */
class User extends Model
{
	//设置数据表（不含前缀)
    protected $name = 'user';
    // 数据表主键 复合主键使用数组定义 不设置则自动获取
    protected $pk = 'uid';

    // 是否需要自动写入时间戳 如果设置为字符串 则表示时间字段的类型
    protected $autoWriteTimestamp=true;
    // 创建时间字段
    protected $createTime = 'create_time';
    // 更新时间字段
    protected $updateTime = 'update_time';
    // 时间字段取出后的默认时间格式
    protected $dateFormat;

    // 新增自动完成列表
	protected $insert = array('create_time','regip');

	protected function setRegipAttr(){
        return request()->ip();
    }

    public function group()
    {
    	return $this->belongsToMany(
    		'AuthGroup', 
    		'\app\common\model\AuthGroup', 
    		'group_id', 
    		'uid'
    	);
    }

    public function getGroupListAttr($value, $data)
    {
    	$group_ids = $group_arr = array();
    	$group_ids = db('AuthGroupAccess')->where('uid', $data['uid'])->column('group_id');
    	$map['id'] = array('in',$group_ids);
    	return implode(',', db('AuthGroup')->where($map)->column('title'));
    }

    public function getGroupIdAttr($value, $data)
    {
    	$group_ids = $group_arr = array();
    	$group_ids = db('AuthGroupAccess')->where('uid', $data['uid'])->column('group_id');
    	return $group_ids ? implode(',', $group_ids) : '';
    }

    /**
     * 密码加密
     */
    public function encrptyPwd($password, $salt)
    {
    	return md5(sha1($password.$salt));
    }

	/**
	 * 用户登录模型
	 */
	public function login($username = '', $password = '', $type = 1)
	{
		$map = array();
		if (\think\Validate::is($username,'email')) {
			$type = 2;
		}elseif (preg_match("/^1[34578]{1}\d{9}$/",$username)) {
			$type = 3;
		}
		switch ($type) {
			case 1:
				$map['username'] = $username;
				break;
			case 2:
				$map['email'] = $username;
				break;
			case 3:
				$map['mobile'] = $username;
				break;
			case 4:
				$map['uid'] = $username;
				break;
			case 5:
				$map['uid'] = $username;
				break;
			default:
				return 0; //参数错误
		}

		$user = $this->where($map)->find();
        if (!$user) {
        	return -1; //用户不存在
        }
      
		/* 验证用户密码 */
		$password = $this->encrptyPwd($password, $user['salt']);
		if($password === $user['password']){
			$this->autoLogin($user); //更新用户登录信息
			return $user['uid']; //登录成功，返回用户ID
		} else {
			return -2; //密码错误
		}
	}

	/**
	 * 自动登录用户
	 * @param  integer $user 用户信息数组
	 */
	public function autoLogin($user)
	{
		/* 更新登录信息 */
		$data = array(
			'uid'             => $user['uid'],
			'login_num'           => array('exp', '`login_num`+1'),
			'last_login_time' => time(),
			'last_login_ip'   => get_client_ip(),
		);
        
		$this->save($data,array('uid'=>$user['uid']));
		$user = $this->where(array('uid'=>$user['uid']))->find();

		/* 记录登录SESSION和COOKIES */
		$auth = array(
			'uid'             => $user['uid'],
			'username'        => $user['username'],
            'nickname'        => $user['nickname'],
            'mobile'          => $user['mobile'],
            
			'last_login_time' => $user['last_login_time'],
		);

		session('user_auth', $auth);
		session('user_auth_sign', data_auth_sign($auth));
	}

	public function logout()
	{
	    $uid = session('user_auth.uid');
        $_SESSION['_auth_list_'.$uid.'1'] ='';
        $_SESSION['_auth_list_'.$uid.'2']='';
        $_SESSION['_auth_list_'.$uid.'in,1,2']='';
        
		session('user_auth', null);
		session('user_auth_sign', null);
	}

	/**
	 * 用户注册
	 * @param  integer $user 用户信息数组
	 */
	public function register($data, $isautologin = true)
	{
		if(empty($data['salt'])){
            $data['salt'] = rand_string(6);
		}
        $data['password'] = $this->encrptyPwd($data['password'], $data['salt']);
        // 用户名不存在，系统内部自动生成
        if (empty($data['username'])) {
        	$username = $this->order('uid desc')->column('username');
        	$data['username'] = rand_string(9, 1);
        }
		// halt($data);
        if($data){       
            $group_ids = isset($data['group_id']) ? $data['group_id'] : [];
            unset($data['group_id']);

            $result = $this->data($data,true)->isUpdate(false)->validate(true)->save();
    		if ($result) {
    		    $data['uid'] = $this->data['uid'];

    		    // 新增用户-角色关联信息
    		    if ($group_ids) {
					model('AuthGroupAccess')->addLink($data['uid'], $group_ids);
					unset($data['group_id']);
    		    }

    			if ($isautologin) {
    				$this->autoLogin($this->data);
    			}

    			return $result;
    		}else{
    			if (!$this->getError()) {
    				$this->error = "注册失败！";
    			}
    			return false;
    		}
        }else{
           $this->error = "非法请示，数据不能为空！"; 
        }
	}

	/**
	 * 修改用户
	 *
	 * @param  array  $data          修改的数据集
	 * @param  boolean $is_change_pwd 是否要修改密码(true:是，false:否)
	 *
	 * @return mixed                 修改结果集
	 */
	public function editUser($data, $is_change_pwd = false, $is_change_group = true)
	{
		if (!empty($data['uid'])) {
			// 修改密码
			if (!$is_change_pwd || ($is_change_pwd && empty($data['password']))) {
				unset($data['salt']);
				unset($data['password']);
			} else {
				$data['salt'] = rand_string(5);
				$data['password'] = $this->encrptyPwd($data['password'], $data['salt']);
			}

			// 重置角色
			if ($is_change_group) {
				$group_ids = isset($data['group_id']) ? $data['group_id'] : [];
				model('AuthGroupAccess')->addLink($data['uid'], $group_ids);
			}
			unset($data['group_id']);

			$result = $this->data($data,true)->isUpdate(true)->validate('User.edit')->save();

			if ($result) {
				return $result;
			}

			return false;
		} else {
			$this->error = '非法操作';
			return false;
		}
	}



	/**
	 * 获取当前用户信息
	 * @return array 
	 */
	public function getCurrentUserInfo()
	{
		$base_info = session('user_auth');
		return $this->where('uid', $base_info['uid'])->find();
	}

	/**
	 * 根据openid获取用户信息
	 *
	 * @return array 用户基本信息
	 */
	public function getUserInfoByOpenid($openid = '')
	{
		$map['openid'] = $openid;
        $user_info = model('User')->where($map)->find();

        if (!$user_info) {
        	$this->error = '用户已经存在';
            return false;
        }

        return $user_info;
	}
}