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
 * 模版消息管理
 */
class TemplateMsg extends Drive {

    /**
     * 发送模版消息
     * @param   interger    $openid      用户openid
     * @param   string      $url            通知详情地址
     * @param   string      $title          通知标题
     */
    public function sendMsg($openid='', $url='', $title='') {

        $openid         = empty($openid) ? I('openid') : $openid;
        $url            = empty($url) ? I('url') : $url;
        $title          = empty($title) ? I('title') : $title;

        if (empty($openid)) {
            throw new \Exception('用户openid不能为空');
        }
        if (empty($title)) {
            throw new \Exception('通知内容不能为空');
        }
        if (empty($url)) {
            throw new \Exception('用户查看通知地址不能为空');
        }

        $template_id = '6_0QwlVjspzkoei_qlfAkllFuPL-KND4h2AJIQ5NDkQ'; //测试模版ID

        //获取用户openid

        $content = array(
            'touser'        => $openid,
            'template_id'   => $template_id,
            'url'           => $url,
        );
        $content['data'] = array(
            'first' => array(
                    'value' => '你有新的消息', //标题
                    'color' => '#173177',
            ),
            'keyword1' => array(
                    'value' => $title,
                    'color' => '#173177', //姓名
            ),
            'keyword2' => array(
                    'value' => '发送成功',
                    'color' => '#173177', //意见内容
            ),
            'keyword3' => array(
                    'value' => date('Y-m-d H:i'), //处理时间
                    'color' => '#173177',
            ),
            'remark' => array(
                    'value' => '点击查看详情', //内容
                    'color' => '#173177',
            ),
        );

        return $this->send($content);
    }

    /**
     * 发模版消息
     */
    protected function send($content) {
        $res = $this->wechat->sendTemplate($content);
        if (!$res) {
            $error = $this->wechat->getError();
            throw new \Exception($error);
        }
        return true;
    }
}