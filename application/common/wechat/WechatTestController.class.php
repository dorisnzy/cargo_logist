<?php
// +----------------------------------------------------------------------
// | 回调测试
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://kunming.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: nongzhengyi <dorisnzy@163.com>
// +----------------------------------------------------------------------
// | History:
// |    [2017-07-28]     nongzhengyi     first release
// +----------------------------------------------------------------------


namespace Api\Controller;

use Think\Controller;

header('content-type:text/html;charset=utf-8');

class WechatTestController extends Controller {

    /**
     * 模拟关注事件
     */
    public function Subscribe() {
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
        $url = 'http://dblzkmrd.at/Api/api.php?c=WechatRequest&=index';
        $this->http($url, $data, 'post');
    }

    /**
     * 扫码关注
     */
    public function scan() {
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
        $url = 'http://dblzkmrd.at/Api/api.php?c=WechatRequest&=index';
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
        
        
        if ($_arr_headers) {
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