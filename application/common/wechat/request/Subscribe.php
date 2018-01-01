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

/**
 * 接收微信公众号关注事件
 */
class Subscribe extends RequestBase {
    use Sign; // 引用签到

    /**
     * 接收消息
     */
    public function dispose() {
        if (preg_match('/^qrscene_/i', $this->content['eventkey'])) {
            $event_key_arr = explode('_', $this->content['eventkey']);
            $qrcode = $event_key_arr[1]; 
            // $this->scanQrcode($qrcode, $this->content['fromusername']);
            $this->response();
        } else {
            $this->response();
        }
    }


    /**
     * 响应消息
     */
    private function response() {
        $title = '@昆明市民 关注“昆明人大之窗”让人大代表听您说';

        $description  = '昆明市第十四届人民代表大会第一次会议于2017年3月19日至3月24日召开。';
        $description .= '会议期间，来自全市各行各业的457名市人大代表将依法履职，';
        $description .= '并就昆明2017年的工作提出议案建议。';
        $description .= '如果您对昆明经济社会发展有好的建议，';
        $description .= '如果您希望将您的宝贵意见送到会场，';
        $description .= '请您关注“昆明人大之窗”微信服务号。';

        $pic_url  = 'https://mmbiz.qpic.cn/mmbiz_jpg/l7oE9oTH3I2hW7kwqrGrUgiaib40GxV83Vx7ibZqGbEXDQo9SkrIYDjmRdxRseyicrI49EkEykQFWR9WeMA2cnmPTw/0?wx_fmt=jpeg';

        $url = 'http://mp.weixin.qq.com/s/QpAS-46Av7fQ6iJccyq0lg';

        $content = array(
            array(
                'Title'       => $title,
                'Description' => $description,
                'PicUrl'      => $pic_url,
                'Url'         => $url,
            )
            
        );
        $this->wechat->response($content,'news');
    }
}