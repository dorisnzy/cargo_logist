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

namespace  app\common\wechat\request;

use app\common\wechat\request\RequestBase;
use app\common\logic\Attachment;

/**
 * 接收微信公众号关注事件
 */
class Subscribe extends RequestBase {

    /**
     * 接收消息
     */
    public function dispose() {
        if (isset($this->content['eventkey']) && preg_match('/^qrscene_/i', $this->content['eventkey'])) { // 扫码关注
            $event_key_arr = explode('_', $this->content['eventkey']);
            $qrcode = $event_key_arr[1];
            $this->register(); 
            $this->response();
        } else { // 普通关注
            $this->register(); 
            $this->response();
        }
    }

    /**
     * 注册用户
     */
    public function register()
    {
        $user_info = model('User')->getUserInfoByOpenid($this->content['fromusername']);
        if ($user_info) {
            return true; //用户已经注册无需注册
        }
        
        // 获取微信用户信息
        $wx_info = $this->wechat->user($this->content['fromusername']);

        if (isset($wx_info['subscribe']) && $wx_info['subscribe'] == 0) {
            throw new \Exception('该用户没有关注公众号');   
        }

        if (isset($wx_info['openid'])) {
            $data['openid']         = $wx_info['openid'];
        }

        if (isset($wx_info['nickname'])) {
            $data['wxname']       = $wx_info['nickname'];
        }

        if (isset($wx_info['sex'])) {
            $data['sex']            = $wx_info['sex'];
        }

        if (isset($wx_info['city'])) {
            $data['city']           = $wx_info['city'];
        }

        if (isset($wx_info['country'])) {
            $data['country']        = $wx_info['country'];
        }

        if (isset($wx_info['province'])) {
            $data['province']       = $wx_info['province'];
        }

        if (isset($wx_info['language'])) {
            $data['language']       = $wx_info['language'];
        }

        if (isset($wx_info['subscribe_time'])) {
            $data['subscribe_time'] = $wx_info['subscribe_time'];
        }

        if (isset($wx_info['remark'])) {
            $data['remark']         = $wx_info['remark'];
        }

        if (isset($wx_info['groupid'])) {
            $data['groupid']        = is_array($wx_info['groupid']) ? json_encode($wx_info['groupid']) : $wx_info['groupid'];
        }

        if (isset($wx_info['tagid_list'])) {
            $data['tagid_list']     = is_array($wx_info['tagid_list']) ? json_encode($wx_info['tagid_list']) : $wx_info['tagid_list'];
        } 
        
        if (!empty($wx_info['unionid'])) {
            $data['unionid']         = $wx_info['unionid'];
        }

        $data['password'] = $data['nickname'];

        $result = model('User')->register($data, false);

        // 处理用户头像
        if (isset($wx_info['headimgurl'])) {
            $attachment = new Attachment;
            $uid = db('user')->where(['openid' => $data['openid']])->value('uid');
            $attachment->wxUploadHeadImg($wx_info['headimgurl'], $wx_info['openid'], $uid);
        }

        if (!$result) {
            throw new \Exception('注册失败，请您重新关注');
        }
    }


    /**
     * 响应消息
     */
    private function response() {
        // $title = '@昆明市民 关注“昆明人大之窗”让人大代表听您说';

        // $description  = '昆明市第十四届人民代表大会第一次会议于2017年3月19日至3月24日召开。';
        // $description .= '会议期间，来自全市各行各业的457名市人大代表将依法履职，';
        // $description .= '并就昆明2017年的工作提出议案建议。';
        // $description .= '如果您对昆明经济社会发展有好的建议，';
        // $description .= '如果您希望将您的宝贵意见送到会场，';
        // $description .= '请您关注“昆明人大之窗”微信服务号。';

        // $pic_url  = 'https://mmbiz.qpic.cn/mmbiz_jpg/l7oE9oTH3I2hW7kwqrGrUgiaib40GxV83Vx7ibZqGbEXDQo9SkrIYDjmRdxRseyicrI49EkEykQFWR9WeMA2cnmPTw/0?wx_fmt=jpeg';

        // $url = 'http://mp.weixin.qq.com/s/QpAS-46Av7fQ6iJccyq0lg';

        // $content = array(
        //     array(
        //         'Title'       => $title,
        //         'Description' => $description,
        //         'PicUrl'      => $pic_url,
        //         'Url'         => $url,
        //     )
            
        // );
        // $this->wechat->response($content,'news');
        $this->wechat->response('欢迎关注圈圈物流！');
    }
}