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

use app\common\wechat\lib\Wechat;

/**
 * 服务端驱动
 */
abstract class Drive {

    protected $wechat;

    /**
     * 初始化
     */
    public function __construct(Wechat $wechat) {
        $this->wechat = $wechat;
        $this->wechat->getToken();
        $this->init();
    }

    public function init() {}

}