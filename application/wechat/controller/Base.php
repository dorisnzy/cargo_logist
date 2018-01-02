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
 * 前台公共控制器
 */
class Base extends Controller
{
	// 当前用户信息
	protected $userInfo;
	// 当前url
	protected $currentUrl;
	// 微信工具类
	protected $wechat;

	// 不需要验证权限的节点
	protected $noaccessUrlArr = [
		'admin/user/login', 
		'admin/user/logout',
		'admin/user/verify',
		'admin/index/index',
	];

	/**
	 * 系统初始化
	 *
	 * @return void
	 */
	protected function _initialize()
	{	
		// 实例化微信工具类
		$this->wechat = \app\common\wechat\lib\WechatFactory::getInstance();

		// 检查是否已经登录
		if (!is_login()) {
			$openid = $this->getOpenid();
            $this->autologin($openid);
		}
		
		$this->userInfo = model('User')->getCurrentUserInfo();

		// 获取当前访问地址
        $this->currentUrl  = $this->request->module() . '/';
		$this->currentUrl .= $this->request->controller() . '/';
		$this->currentUrl .= $this->request->action();

		$this->currentUrl  = strtolower($this->currentUrl);

		// 是否是超级管理员
		defined('IS_ROOT') or define('IS_ROOT', is_administrator());

		if (!in_array($this->currentUrl, $this->noaccessUrlArr)) {            
            // 检测系统权限
			// if (!IS_ROOT) {
   //              //检测访问权限
   //              if (!$this->checkRule($this->currentUrl, array('in', '1,2'))) {
   //              	$this->error('未授权访问!');
   //              }
			// }
        }

        $this->_init();
	}

	/**
	 * 前台初始化
	 *
	 * @return void 
	 */
	protected function _init()
	{

	}

	/**
	 * 获取用户openid
	 *
	 * @author dorisnzy <dorisnzy@163.com>
	 *
	 * @return string 用户opendid 只适用于单个公众号
	 */
	public function getOpenid()
	{
		$url = $this->request->url(true);
		$code = input('code', '');

		if(!$code){
            $state  = md5(uniqid(rand(), true));
            session('wx_state', $state); //存到SESSION
            $url = $this->wechat->getOAuthRedirect($url, $state);
            
            $this->redirect($url);
        }

        if ($data = $this->wechat->getOauthAccessToken()) {
        	return $data['openid'];
        }

        return $this->error($this->wechat->getError());
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
    }

    /**
	 * 设置meta_title
	 *
	 * @author dorisnzy <dorisnzy@163.com>
	 *
	 * @param  string $meta_title 标题信息
	 */
	protected function setMeta($meta_title = '')
	{
		$this->assign('meta_title', $meta_title);
	}

	/**
	 * 权限检测
	 * @param string  $rule    检测的规则
	 * @param string  $mode    check模式
	 * @return boolean
	 */
	final protected function checkRule($rule, $type = 1, $mode = 'url')
	{
		static $Auth = null;
		if (!$Auth) {
			$Auth = new \app\common\org\Auth();
		}

		if (!$Auth->check($rule, session('user_auth.uid'), $type, $mode)) {
			return false;
		}
		return true;
	}
}