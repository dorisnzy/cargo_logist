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

namespace app\admin\controller;

use app\admin\controller\Base;

/**
 * 会员控制器
 */
class User extends Base
{
	// 用户模型
    protected $modelUser;

	/**
	 * 后台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{
		$this->modelUser = model('User');
		$this->setMeta('用户管理');

		// 用户组操作
		$action_arr = ['add', 'edit'];
		if (in_array($this->request->action(), $action_arr)) {
			$group_list = model('AuthGroup')->where(['status' => 1])->select();
			$this->assign('group_list', $group_list);
		}
	}

	/**
	 * 用户列表
	 */
	public function index()
	{
		$map = [];
        
        // 按昵称搜索
        if ($this->request->param('nickname')) {
            $map['nickname'] = ['like', '%'. $this->request->param('nickname') . '%'];
        }

        // 按手机号搜索
        if ($this->request->param('mobile')) {
            $map['mobile'] = ['like', '%'. $this->request->param('mobile') . '%'];
        }

        if ($this->request->isAjax()) {
            $count = $this->modelUser->where($map)->count();

            $list  = $this->modelUser
                ->where($map)
                ->page($this->modelUser->getPageNow(), $this->modelUser->getPageLimit())
                ->select()
            ;

            if (!$list) {
                return $this->error('信息不存在');
            }

            $this->assign('list', $list);
            $html = $this->fetch('index_ajax');

            $data = [
                'list'  => $html,
                'count' => $count,
                'limit' => $this->modelUser->getPageLimit()
            ];

            return $this->success('获取成功', '', $data);
        }

		return $this->fetch();
	}

	/** 
	 * 新增用户
	 */
	public function add()
	{
		if ($this->request->isPost()) {
			$data = input('post.');
			$res = $this->modelUser->register($data, false);
			if (!$res) {
				return $this->error('新增失败');
			}

			return $this->success('新增成功');
		}

		return $this->fetch('edit');
	}

	/**
	 * 编辑用户
	 */
	public function edit($uid = 0)
	{

	}

	/** 
	 * 删除用户
	 */
	public function del()
	{

	}

	/**
     * 后台登录
     *
     * @param  string $username 账号
     * @param  string $password 密码
     * @param  string $verify   验证码
     * 
     * @return string
     */
    public function login($username = '', $password = '', $verify = ''){
        if (request()->isPost()) {
            if (!$username || !$password) {
				return $this->error('用户名或者密码不能为空！', '');
			}

            $this->checkVerify($verify);

            $user = model('User');
            $uid  = $user->login($username, $password);
            if ($uid > 0) {
				return $this->success('登录成功！', url('admin/index/index'));
			} else {
				switch ($uid) {
				case -1:$error = '用户不存在或被禁用！';
					break; //系统级别禁用
				case -2:$error = '密码错误！';
					break;
				default:$error = '未知错误！';
					break; // 0-接口参数错误（调试阶段使用）
				}
				return $this->error($error, '');
			}
        }else{
            if (is_login()) {
                $this->success("您已经是登陆状态！", url('admin/index/index'));
            }
        
            $this->setMeta('登录');
            return $this->fetch();
        }
    }

    /**
     * 后台退出登录
     * @access public
     * @param  empty
     * 
     * @return void
     */
    public function logout() {
		$user = model('User');
		$user->logout();
		$this->redirect('admin/index/login');
	}

	/**
	 * 验证码
	 * @param  integer $id 验证码ID
	 */
	public function verify($id = 1) {
		$config = [
            'fontSize' => 15,
        ];
        $captcha = new \think\captcha\Captcha($config);

        return $captcha->entry();
	}

	/**
	 * 检测验证码
	 * @param  integer $id 验证码ID
	 * @return boolean     检测结果
	 */
	public function checkVerify($code, $id = 1) {
		if ($code) {
			$captcha = new \think\captcha\Captcha();
			$result = $captcha->check($code, $id);
			if (!$result) {
				return $this->error("验证码错误！", "");
			}
		} else {
			return $this->error("验证码为空！", "");
		}
	}
}