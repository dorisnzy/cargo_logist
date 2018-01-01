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

namespace app\common\wechat\server;

use app\common\wechat\server\Drive;

/**
 * 二维码息管理
 */
class QrCode extends Drive {


    /**
     * 生成二维码，目前只支持零时二维码
     * @param  integer     $qrcode      code码
     * @param  bool        $limit     true-永久二维码，false-零时二维码，默认为false-零时二维码
     * @param  integer     $expire    临时二维码有效时间，永久二维码该参数不起作用
     * @return 成功-二维码图片地址，失败-false
     */
    public function getQrcode($qrcode = '', $limit = false, $expire = 7200) {
        empty($qrcode)  &&  $this->error('qrcode不能为空');
        if (empty($qrcode)) {
            throw new \Exception('qrcode不能为空');
        }
        $src = $this->wechat->getQRUrl($qrcode, $limit, $expire, true);
        if (!$src) {
            $errmsg = $this->wechat->getError();
            throw new \Exception($errmsg);
        }
        return $src;
    }
}