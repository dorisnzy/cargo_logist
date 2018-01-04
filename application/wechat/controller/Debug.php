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
use app\common\wechat\lib\ServerFactory;

/**
 * 调试控制器
 */
class Debug extends Controller
{
	protected function _initialize()
	{
		try {
            $this->menu = ServerFactory::getInstance('menu');
        } catch (\Exception $e) {
            dump($e->getMessage());die;
        }
	}
	
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
        $user = model('User')->where(array('username'=>'900730439'))->find();
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

    /**
     * 创建微信菜单
     */
    public function createMenu()
    {
        try {
            $res = $this->menu->create();
            dump($res);
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }

    /**
     * 模拟关注事件
     */
    public function Subscribe() 
    {
        $data = <<<EOF
<xml>
<ToUserName>touser</ToUserName>
<FromUserName>oPzXewEOA3QYw-Y-P1swkGca9of0</FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType>event</MsgType>
<Event>subscribe</Event>
<EventKey>qrscene_2</EventKey>
</xml>
EOF;
        $url = 'http://cargo.at/wechat/wechat_request/index';
        $this->http($url, $data, 'post');
    }

    /**
     * 扫码关注
     */
    public function scan() 
    {
        $data = <<<EOF
<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName>oPzXewEOA3QYw-Y-P1swkGca9of0</FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[SCAN]]></Event>
<EventKey>1</EventKey>
<Ticket><![CDATA[TICKET]]></Ticket>
</xml>
EOF;
        $url = 'http://cargo.at/wechat/wechat_request/index';
        $this->http($url, $data, 'post');
    }

    /**
     * 点击菜单事件发布需求
     */
    public function clickMenuSendOrder()
    {   
        $data = <<<EOF
<xml>
<ToUserName>asdf</ToUserName>
<FromUserName>ogZD6wpXliPpZnsy86Yw0FP_RrBc</FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType>event</MsgType>
<Event>click</Event>
<EventKey>send_order</EventKey>
</xml>
EOF;
        $url = 'http://cargo.at/wechat/wechat_request/index';
        $this->http($url, $data, 'post');
    }

    /**
     * 关注事件
     */
    public function wxsubscribe()
    {
        $data = <<<EOF
<xml>
<ToUserName>asdf</ToUserName>
<FromUserName>ogZD6wpXliPpZnsy86Yw0FP_RrBc</FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType>event</MsgType>
<Event>subscribe</Event>
</xml>
EOF;
        $url = 'http://cargo.at/wechat/wechat_request/index';
        $this->http($url, $data, 'post');
    }

    /** http 方法函数
     * @param mixed $str_url
     * @param mixed $arr_data
     * @param string $str_method (default: "get")
     * @return void
     */
    protected function http($str_url, $_str_data, $str_method = "get",$header_str='')
    {
        $_obj_http = curl_init();
        if(isset($header_str)){
        }else{
            $_arr_headers = array(
                "Content-Type: application/x-www-form-urlencoded",
                "Content-length: " . strlen($_str_data),
            );
        }
        
        
        if (isset($_arr_headers)) {
            curl_setopt($_obj_http, CURLOPT_HTTPHEADER, $_arr_headers);
        }
        
        if ($str_method == "post") {
            curl_setopt($_obj_http, CURLOPT_POST, true);
            curl_setopt($_obj_http, CURLOPT_POSTFIELDS, $_str_data);
            curl_setopt($_obj_http, CURLOPT_URL, $str_url);
        } else {
            if (stristr($str_url, "?")) {
                $_str_conn = "&";
            } else {
                $_str_conn = "?";
            }
            curl_setopt($_obj_http, CURLOPT_URL, $str_url . $_str_conn . $_str_data);
        }
        
        curl_setopt($_obj_http, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($_obj_http, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环 
        
        $_obj_ret = curl_exec($_obj_http);
        $httpCode = curl_getinfo($_obj_http, CURLINFO_HTTP_CODE);
        
        $_arr_return = array(
            "err"     => curl_error($_obj_http),
            "errno"   => curl_errno($_obj_http),
            "ret"     => $_obj_ret,
        );
    
        print_r($_obj_ret);
        
        curl_close($_obj_http);
    
        return $_arr_return;
    }
}