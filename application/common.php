<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login() 
{
	$user = session('user_auth');
	if (empty($user)) {
		return 0;
	} else {
		return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
	}
}

/**
 * 根据用户ID获取用户名
 * @param  integer $uid 用户ID
 * @return string       用户名
 */
function get_username($uid = 0) 
{
	static $list;
	if (!($uid && is_numeric($uid))) {
		//获取当前登录用户名
		return session('user_auth.username');
	}
	$name = db('user')->where(array('uid' => $uid))->value('username');
	return $name;
}

/**
 * 检测当前用户是否为超级管理员
 * @return boolean true-管理员，false-非管理员
 */
function is_administrator($uid = null)
{
	$uid = is_null($uid) ? is_login() : $uid;
    if(in_array($uid,config('app.user_administrator'))){
		return $uid;
	}else{
		return false;
	}
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 */
function data_auth_sign($data)
{
	//数据类型检测
	if (!is_array($data)) {
		$data = (array) $data;
	}
	ksort($data); //排序
	$code = http_build_query($data); //url编码并生成query字符串
	$sign = sha1($code); //生成签名
	return $sign;
}

/**
 * 不区分大小写的in_array实现
 * @param string $value 值
 * @param array $array 数组
 * @return bloo
 */
function in_array_case($value, $array) 
{
	return in_array(strtolower($value), array_map('strtolower', $array));
}


/**
 *----------------------------------------------------------
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
 *---------------------------------------------------------
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 *---------------------------------------------------------
 * @return string
 *---------------------------------------------------------
 */
function rand_string($len = 6, $type = '', $addChars = '')
{
	$str = '';
	switch ($type) {
	case 0:
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
		break;
	case 1:
		$chars = str_repeat('0123456789', 3);
		break;
	case 2:
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
		break;
	case 3:
		$chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
		break;
	case 4:
		$chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借" . $addChars;
		break;
	default:
		// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
		$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
		break;
	}
	if ($len > 10) {
		//位数过长重复字符串一定次数
		$chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
	}
	if ($type != 4) {
		$chars = str_shuffle($chars);
		$str   = substr($chars, 0, $len);
	} else {
		// 中文随机字
		for ($i = 0; $i < $len; $i++) {
			$str .= msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
		}
	}
	return $str;
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = true)
{
	$type      = $type ? 1 : 0;
	static $ip = NULL;
	if ($ip !== NULL) {
		return $ip[$type];
	}

	if ($adv) {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$pos = array_search('unknown', $arr);
			if (false !== $pos) {
				unset($arr[$pos]);
			}

			$ip = trim($arr[0]);
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	} elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	// IP地址合法验证
	$long = sprintf("%u", ip2long($ip));
	$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
	return $ip[$type];
}

/**
 * 获取数据状态
 */
function get_status_format($status)
{
	switch ($status) {
		case -1 :
			$dot = '<span class="layui-badge-rim">回收</span>';
			break;
		case 0 :
			$dot = '<span class="layui-badge-rim layui-bg-gray">禁用</span>';
			break;
		case 1 :
			$dot = '<span class="layui-badge-rim layui-bg-blue">启用</span>';
			break;
	}

	return $dot;
}

/**
 * 权限校验
 * $url URL地址
 * @return boolean
 */
function check_rule($url){
	$count = count(explode('/', $url));

	if ($count == 1) {
		$rule = request()->module() . '/' . request()->dispatch()['module'][1] . '/' . $url;
	} else if ($count == 2) {
		$rule = request()->module() . '/' . $url;
	} else if ($count == 3) {
		$rule = $url;
	} else {
		return false;
	}

	static $Auth = null;

	if (!$Auth) {
		$Auth = new \app\common\org\Auth();
	}
	if (!IS_ROOT && !$Auth->check($rule, session('user_auth.uid'), 1, 'url')) {
		return false;
	}

	return true;
}

/**
 * 获取订单状态中文标识
 *
 * @param  integer $order_status 订单状态值
 *
 * @return string                状态中文标识
 */	
function get_order_status($order_status = 0)
{
	switch ($order_status) {
		case 0 :
			$status_title = '发布成功，平台收到待分配取货者';
			break;
		case 20 :
			$status_title = '平台已指派，待取货者确认';	
			break;
		case 40 :
			$status_title = '取货者已经确认，正赶往取货点地';	
			break;
		case 60 :
			$status_title = '取货者已到达取货地';	
			break;
		case 80 :
			$status_title = '已取货，待分配司机送货';	
			break;
		case 100 :
			$status_title = '已分配司机送货';	
			break;
		case 120 :
			$status_title = '完成回到平台所在，取货完成';
			break;
		default :
			$status_title = '未知';
	}
	return $status_title;
}

/**
 * 获取司机送货订单中文标识
 */
function get_send_status($send_status = 0)
{
	switch ($send_status) {
		case 0 :
			$send_title = '发布成功，平台收到待分配送货者司机';
			break;
		case 20 :
			$send_title = '已经分配司机取货，待司机确认';
			break;
		case 40 :
			$send_title = '送货司机已经确认';
			break;
		case 60 :
			$send_title = '司机已到达取货点';
			break;
		case 80 :
			$send_title = '司机已取货';
			break;
		case 100 :
			$send_title = '司机已送达目的地';
			break;
		case 120 :
			$send_title = '目的地商家确认收货';
			break;
		case 140 :
			$send_title = '司机完成送货已回到平台所在，送货整体完成';
			break;
		default :
			$send_title = '未知';
	}

	return $send_title;
}
