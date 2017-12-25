<?php
// +----------------------------------------------------------------------
// | 公共用户模型
// +----------------------------------------------------------------------
// | @copyright (c) lishaoen.com All rights reserved.
// +----------------------------------------------------------------------
// | @author: lishaoen <lishaoen@gmail.com>
// +----------------------------------------------------------------------
// | @version: v1.0
// +----------------------------------------------------------------------

namespace app\common\model;
use app\common\model\Model;

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
	protected $insert = array('password','create_time','regip');

	protected function setPasswordAttr($value, $data){
		return md5($value.$data['salt']);
	}

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
        
		if(isset($user['status']) && $user['status']){
			/* 验证用户密码 */
			if(md5($password.$user['salt']) === $user['password']){
				$this->autoLogin($user); //更新用户登录信息
				return $user['uid']; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
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
			'login'           => array('exp', '`login`+1'),
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
        if($data){       
            $data['status'] = 1;

            $group_ids = $data['group_id'];
            unset($data['group_id']);

            $result = $this->data($data,true)->isUpdate(false)->validate(true)->save();

    		if ($result) {
    		    $data['uid'] = $this->data['uid'];
    		    $this->group()->saveAll($group_ids);

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
	 * 获取当前用户信息
	 * @return array 
	 */
	public function getCurrentUserInfo()
	{
		return session('user_auth');
	}
}