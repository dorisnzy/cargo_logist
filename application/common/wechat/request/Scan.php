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
 * 接收微信公众号扫码事件
 */
class Scan extends RequestBase {

    /**
     * 接收消息
     */
    public function dispose() {
        $this->scanQrcode($this->content['eventkey'], $this->content['fromusername']);
    }
}