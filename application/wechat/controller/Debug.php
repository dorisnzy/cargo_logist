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

namespace app\wechat\controller;

use think\Controller;

/**
 * 调试控制器
 */
class Debug extends Controller
{

	/**
	 * 模拟系统登录
	 *
	 * @author dorisnzy <dorisnzy@163.com>
	 *
	 * @return void
	 */
	public function index()
	{
		// 线下调试用
        $user = model('User')->where(array('username'=>'admin'))->find();
        $this->autologin($user['openid']);
	}


	/**
	 * 自动登录
	 *
	 * @author dorisnzy <dorisnzy@163.com>
	 *
	 * @param  string $openid 用户openid
	 *
	 * @return bolean         
	 */
    protected function autologin($openid)
    {
    	$map['openid'] = $openid;

    	$info = db('user')->where($map)->find();

    	if (!$info) {
    		return $this->error('您还没有关注公众号号，请您先去关注了再来访问');
    	}

    	// 登录用户
    	model('User')->autoLogin($info);

    	$this->redirect('index/index');
    }

    public function logout()
    {
    	model('User')->logout();
    	halt('退出登录成功');
    }
}