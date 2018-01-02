/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : cargo

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-02 18:17:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ca_address_map
-- ----------------------------
DROP TABLE IF EXISTS `ca_address_map`;
CREATE TABLE `ca_address_map` (
  `map_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `longitude` varchar(50) NOT NULL DEFAULT '' COMMENT '地理位置经度',
  `latitude` varchar(50) NOT NULL DEFAULT '' COMMENT '地理位置纬度',
  `precision` varchar(50) NOT NULL DEFAULT '' COMMENT '地理位置精度',
  `op_uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作用户uid  根据type来判断是哪种uid，(例如：取货人uid， 司机的uid)',
  `type` smallint(4) NOT NULL DEFAULT '3' COMMENT '用户类型（3取货者，4司机）',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '上传时间',
  PRIMARY KEY (`map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地理位置表';

-- ----------------------------
-- Records of ca_address_map
-- ----------------------------

-- ----------------------------
-- Table structure for ca_attachment
-- ----------------------------
DROP TABLE IF EXISTS `ca_attachment`;
CREATE TABLE `ca_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '附件id',
  `owner` int(11) NOT NULL DEFAULT '0' COMMENT '文件拥有者',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '附件名称',
  `savename` varchar(255) NOT NULL DEFAULT '' COMMENT '保存文件名',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '附件路径',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '附件链接',
  `ext` varchar(40) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` varchar(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '附件类型',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '附件大小',
  `md5` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '附件MD5',
  `sha1` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '文件sha1编码',
  `remark` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '附件备注',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '附件存储位置',
  `ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '附件上传IP',
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ca_attachment
-- ----------------------------
INSERT INTO `ca_attachment` VALUES ('11', '0', 'bdb015e28497da3776400fd60ea689d0.jpg', 'bdb015e28497da3776400fd60ea689d0.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\bdb015e28497da3776400fd60ea689d0.jpg', 'jpg', 'image/jpeg', '', '92697', '45f714fde25cc58e2f1e647841832d7e', 'c9ebc7ca874479cebaca243f4cb2d708013d4144', '', '1514883784', '1514883784', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');
INSERT INTO `ca_attachment` VALUES ('12', '0', '9776cb5291fd4134e014b82891484ba1.jpg', '9776cb5291fd4134e014b82891484ba1.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\9776cb5291fd4134e014b82891484ba1.jpg', 'jpg', 'image/jpeg', '', '91497', 'ed22ffbbd89aeeb56d8c07454a4e89b8', '289954567fc3d2ecd0166629a4bd46c7963f6ced', '', '1514883787', '1514883787', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');
INSERT INTO `ca_attachment` VALUES ('13', '0', '9cc898564137ae39ae7c1a77fd9ae61c.jpg', '9cc898564137ae39ae7c1a77fd9ae61c.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\9cc898564137ae39ae7c1a77fd9ae61c.jpg', 'jpg', 'image/jpeg', '', '30901', '563476e23e8a0a5ca886e92264d1e6a8', '7eeb9a0b45ecb0c5877d006fcab8062999f1834b', '', '1514883927', '1514883927', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');
INSERT INTO `ca_attachment` VALUES ('14', '0', '20c01d7928d3a110ad0884d3723194d6.jpg', '20c01d7928d3a110ad0884d3723194d6.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\20c01d7928d3a110ad0884d3723194d6.jpg', 'jpg', 'image/jpeg', '', '30901', '563476e23e8a0a5ca886e92264d1e6a8', '7eeb9a0b45ecb0c5877d006fcab8062999f1834b', '', '1514884011', '1514884011', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');
INSERT INTO `ca_attachment` VALUES ('15', '0', 'f15f9e120cea49fe497e773e4fec7da1.jpg', 'f15f9e120cea49fe497e773e4fec7da1.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\f15f9e120cea49fe497e773e4fec7da1.jpg', 'jpg', 'image/jpeg', '', '30901', '563476e23e8a0a5ca886e92264d1e6a8', '7eeb9a0b45ecb0c5877d006fcab8062999f1834b', '', '1514884726', '1514884726', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');
INSERT INTO `ca_attachment` VALUES ('16', '0', 'a4fabcfca587cdf4408faabccd056207.jpg', 'a4fabcfca587cdf4408faabccd056207.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\a4fabcfca587cdf4408faabccd056207.jpg', 'jpg', 'image/jpeg', '', '30901', '563476e23e8a0a5ca886e92264d1e6a8', '7eeb9a0b45ecb0c5877d006fcab8062999f1834b', '', '1514884892', '1514884892', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');
INSERT INTO `ca_attachment` VALUES ('17', '0', 'af566a47a7935e800ea647d084bd3500.jpg', 'af566a47a7935e800ea647d084bd3500.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\af566a47a7935e800ea647d084bd3500.jpg', 'jpg', 'image/jpeg', '', '92697', '45f714fde25cc58e2f1e647841832d7e', 'c9ebc7ca874479cebaca243f4cb2d708013d4144', '', '1514884893', '1514884893', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');
INSERT INTO `ca_attachment` VALUES ('18', '0', '91f1cd947a3fd1add0cc9d2b5084c1d9.jpg', '91f1cd947a3fd1add0cc9d2b5084c1d9.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\91f1cd947a3fd1add0cc9d2b5084c1d9.jpg', 'jpg', 'image/jpeg', '', '92697', '45f714fde25cc58e2f1e647841832d7e', 'c9ebc7ca874479cebaca243f4cb2d708013d4144', '', '1514885840', '1514885840', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');
INSERT INTO `ca_attachment` VALUES ('19', '0', 'b9580327d95400f93916dad4876a774a.jpg', 'b9580327d95400f93916dad4876a774a.jpg', 'D:\\phphome\\www\\cargo_logist\\public\\uploads\\20180102', '\\uploads\\20180102\\b9580327d95400f93916dad4876a774a.jpg', 'jpg', 'image/jpeg', '', '91497', 'ed22ffbbd89aeeb56d8c07454a4e89b8', '289954567fc3d2ecd0166629a4bd46c7963f6ced', '', '1514885916', '1514885916', '100', '1', 'D:\\phphome\\www\\cargo_logist\\public', '127.0.0.1');

-- ----------------------------
-- Table structure for ca_attachment_user
-- ----------------------------
DROP TABLE IF EXISTS `ca_attachment_user`;
CREATE TABLE `ca_attachment_user` (
  `attachment_id` int(11) NOT NULL COMMENT '自增长ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `scene_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '附件使用场景类型（1用户头像，2取货者验货上传的图片，3司机送货成功验货上传的图片）',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '额外场景值',
  UNIQUE KEY `user_attachment` (`attachment_id`,`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件_用户关联表';

-- ----------------------------
-- Records of ca_attachment_user
-- ----------------------------
INSERT INTO `ca_attachment_user` VALUES ('18', '1', '2', '1');
INSERT INTO `ca_attachment_user` VALUES ('19', '1', '2', '1');

-- ----------------------------
-- Table structure for ca_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `ca_auth_group`;
CREATE TABLE `ca_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1-正常，0-禁用',
  `rules` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id,多个规则","隔开',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ca_auth_group
-- ----------------------------
INSERT INTO `ca_auth_group` VALUES ('1', '创始人组', '1', '1,2,3,4,5,6,7,8,9,10,11,12');
INSERT INTO `ca_auth_group` VALUES ('3', '供货商', '1', '');
INSERT INTO `ca_auth_group` VALUES ('4', '调度者', '1', '');
INSERT INTO `ca_auth_group` VALUES ('5', '取货员', '1', '');
INSERT INTO `ca_auth_group` VALUES ('6', '司机', '1', '');

-- ----------------------------
-- Table structure for ca_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `ca_auth_group_access`;
CREATE TABLE `ca_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ca_auth_group_access
-- ----------------------------
INSERT INTO `ca_auth_group_access` VALUES ('1', '1');
INSERT INTO `ca_auth_group_access` VALUES ('2', '1');
INSERT INTO `ca_auth_group_access` VALUES ('8', '3');
INSERT INTO `ca_auth_group_access` VALUES ('8', '4');
INSERT INTO `ca_auth_group_access` VALUES ('13', '1');
INSERT INTO `ca_auth_group_access` VALUES ('14', '1');
INSERT INTO `ca_auth_group_access` VALUES ('15', '1');
INSERT INTO `ca_auth_group_access` VALUES ('16', '1');
INSERT INTO `ca_auth_group_access` VALUES ('17', '1');

-- ----------------------------
-- Table structure for ca_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `ca_auth_rule`;
CREATE TABLE `ca_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(120) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '为1正常，为0禁用',
  `group` varchar(100) NOT NULL DEFAULT '' COMMENT '权限组，配置中定义',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `module` varchar(50) NOT NULL DEFAULT '' COMMENT '所属模块',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ca_auth_rule
-- ----------------------------
INSERT INTO `ca_auth_rule` VALUES ('1', 'admin/index/index', '首页', '2', '1', '顶级菜单', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('2', 'admin/user/index', '系统', '2', '1', '顶级菜单', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('3', 'admin/menu/index', '菜单列表', '1', '1', '菜单管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('4', 'admin/menu/add', '新增菜单', '1', '1', '菜单管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('5', 'admin/menu/edit', '编辑菜单', '1', '1', '菜单管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('6', 'admin/menu/delete', '删除菜单', '1', '1', '菜单管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('7', 'admin/user/index', '用户列表', '1', '1', '用户管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('8', 'admin/user/add', '注册用户', '1', '1', '用户管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('9', 'admin/user/edit', '编辑用户', '1', '1', '用户管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('10', 'admin/user/delete', '删除用户', '1', '1', '用户管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('11', 'admin/user/editpwd', '修改密码', '1', '1', '用户管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('12', 'admin/group/index', '角色列表', '1', '1', '角色管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('13', 'admin/group/add', '新增角色', '1', '1', '角色管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('14', 'admin/group/edit', '编辑角色', '1', '1', '角色管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('15', 'admin/group/auth', '授权', '1', '1', '角色管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('16', 'admin/group/delete', '删除角色', '1', '1', '角色管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('17', 'admin/rule/index', '权限列表', '1', '1', '权限管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('18', 'admin/rule/add', '新增权限', '1', '1', '权限管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('19', 'admin/rule/edit', '编辑权限', '1', '1', '权限管理', '', 'admin');
INSERT INTO `ca_auth_rule` VALUES ('20', 'admin/rule/delete', '删除权限', '1', '1', '权限管理', '', 'admin');

-- ----------------------------
-- Table structure for ca_config
-- ----------------------------
DROP TABLE IF EXISTS `ca_config`;
CREATE TABLE `ca_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '配置名称',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '配置标贴',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '配置类型',
  `group` tinyint(4) NOT NULL DEFAULT '0' COMMENT '配置分组',
  `options` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '配置额外值',
  `value` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '配置值',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `sort` tinyint(4) NOT NULL DEFAULT '100' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of ca_config
-- ----------------------------

-- ----------------------------
-- Table structure for ca_menu
-- ----------------------------
DROP TABLE IF EXISTS `ca_menu`;
CREATE TABLE `ca_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单节点',
  `module` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单所属模块',
  `group` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单所属分组',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '菜单类型（1：主菜单，2：节点菜单）',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0-禁用 1-启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of ca_menu
-- ----------------------------
INSERT INTO `ca_menu` VALUES ('1', '系统', 'admin/user/index', 'admin', '系统管理', '1', null, '0', '100', '1');
INSERT INTO `ca_menu` VALUES ('2', '会员', 'admin/user/index', 'admin', '系统管理', '2', null, '1', '100', '1');
INSERT INTO `ca_menu` VALUES ('3', '角色', 'admin/group/index', 'admin', '系统管理', '2', null, '1', '100', '1');
INSERT INTO `ca_menu` VALUES ('4', '菜单', 'admin/menu/index', 'admin', '系统管理', '2', null, '1', '100', '1');
INSERT INTO `ca_menu` VALUES ('6', '权限', 'admin/rule/index', 'admin', '系统管理', '2', null, '1', '100', '1');
INSERT INTO `ca_menu` VALUES ('7', '首页', 'admin/index/index', 'admin', '其它', '1', null, '0', '1', '1');

-- ----------------------------
-- Table structure for ca_merchant
-- ----------------------------
DROP TABLE IF EXISTS `ca_merchant`;
CREATE TABLE `ca_merchant` (
  `merchant_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '商家名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商家类型（注：1供应商家，2目的地商家）',
  `province` varchar(100) NOT NULL DEFAULT '' COMMENT '商家所在省份',
  `city` varchar(100) NOT NULL DEFAULT '' COMMENT '商家所在城市',
  `county` varchar(100) NOT NULL DEFAULT '' COMMENT '商家所在县区',
  `supplier_address` varchar(255) NOT NULL DEFAULT '' COMMENT '商家详细地址',
  `longitude` varchar(50) NOT NULL DEFAULT '' COMMENT '地理位置经度',
  `latitude` varchar(50) NOT NULL DEFAULT '' COMMENT '地理位置纬度',
  `precision` varchar(50) NOT NULL DEFAULT '' COMMENT '地理位置精度',
  PRIMARY KEY (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商家表，包括供应商和收货商';

-- ----------------------------
-- Records of ca_merchant
-- ----------------------------
INSERT INTO `ca_merchant` VALUES ('1', '昆明信息港', '1', '云南省', '昆明市', '五华区', '高新区西城时代', '', '', '');

-- ----------------------------
-- Table structure for ca_notice
-- ----------------------------
DROP TABLE IF EXISTS `ca_notice`;
CREATE TABLE `ca_notice` (
  `notice_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `scene_url` varchar(100) NOT NULL DEFAULT '' COMMENT '点击跳转到具体业务业务逻辑的url',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '收到通知的用户uid',
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='通知表';

-- ----------------------------
-- Records of ca_notice
-- ----------------------------

-- ----------------------------
-- Table structure for ca_order
-- ----------------------------
DROP TABLE IF EXISTS `ca_order`;
CREATE TABLE `ca_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商id',
  `supplier_uid` int(11) NOT NULL DEFAULT '0' COMMENT '供应商用户uid',
  `publish_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `maybe_time` int(11) NOT NULL DEFAULT '0' COMMENT '预计到达时间 （自动在发布时间后加三十分钟）',
  `order_remark` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '订单备注',
  `order_status` int(11) NOT NULL DEFAULT '0' COMMENT '订单状态 0 发布成功平台收到待分配取货者 20待取货者确认  40-取货确认  60 - 已到达   80-已取货  100 发布司机送货单 120 完成回到平台所在，取货整体完成',
  `order_product` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '产品名称 - 有可能用到',
  `order_product_price` varchar(10) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '产品价格 - 有可能用到',
  `pay_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否代收货款（0：不是，1：是）',
  `site_sn` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '记账凭证号，线下有个单子，单子的号码，取货的人填',
  `take_uid` int(11) NOT NULL DEFAULT '0' COMMENT '取货人uid',
  `take_time` int(11) NOT NULL DEFAULT '0' COMMENT '取货时间',
  `target_uid` int(11) NOT NULL DEFAULT '0' COMMENT '目的地商家用户表',
  `target_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '目的地商家名称',
  `target_username` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '目的地商家联系人',
  `target_tel` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '0' COMMENT '电话',
  `target_address` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '详细地址',
  `target_lng` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '目的地商家 经度',
  `target_lat` varchar(255) NOT NULL DEFAULT '' COMMENT '目的地商家 维度',
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='供应商发布需求，补充完善信息表';

-- ----------------------------
-- Records of ca_order
-- ----------------------------
INSERT INTO `ca_order` VALUES ('1', '1', '2', '0', '30', 'adf，', '80', '', '', '1', '', '1', '0', '0', '', 'nog', '', '云南省昆明市盘龙区沣源路昆明市北部汽车客运站', '', '');

-- ----------------------------
-- Table structure for ca_order_log
-- ----------------------------
DROP TABLE IF EXISTS `ca_order_log`;
CREATE TABLE `ca_order_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应订单id',
  `order_status` int(255) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `op_uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作用户uid  根据status来判断是哪种uid 发布需求的uid 取货的uid',
  `log_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `log_msg` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '日志备注，专门针对这个环节的备注',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='供应商发布需求，状态变化日志表';

-- ----------------------------
-- Records of ca_order_log
-- ----------------------------
INSERT INTO `ca_order_log` VALUES ('1', '1', '0', '1', '1514821289', '发布成功,平台收到待分配取货者');
INSERT INTO `ca_order_log` VALUES ('2', '1', '20', '1', '1514821289', '已指派取货人');
INSERT INTO `ca_order_log` VALUES ('3', '1', '40', '1', '1514821289', '已经指派取货人');
INSERT INTO `ca_order_log` VALUES ('5', '1', '60', '1', '1514824399', '取货人已到达取货地点');
INSERT INTO `ca_order_log` VALUES ('10', '1', '80', '1', '1514887299', '取货成功');

-- ----------------------------
-- Table structure for ca_pay
-- ----------------------------
DROP TABLE IF EXISTS `ca_pay`;
CREATE TABLE `ca_pay` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `order_num` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `pay_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '付款方式（注：1卡，2现金，3代收货款、4微信支付，5支付宝支付）',
  `pay_scene` tinyint(1) NOT NULL DEFAULT '1' COMMENT '支付场景（注：1线上支付，2线下支付）',
  `pay_status` tinyint(1) NOT NULL COMMENT '付款状态（注：1未付款，2已付款）',
  `pay_price` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `create_time` int(1) NOT NULL DEFAULT '0' COMMENT '生成订单时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改订单时间',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '支付人用户uid',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付订单表';

-- ----------------------------
-- Records of ca_pay
-- ----------------------------

-- ----------------------------
-- Table structure for ca_pay_alinotice
-- ----------------------------
DROP TABLE IF EXISTS `ca_pay_alinotice`;
CREATE TABLE `ca_pay_alinotice` (
  `order_id` int(10) NOT NULL,
  `out_trade_no` varchar(100) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '商户订单号',
  `gmt_create` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '交易创建时间',
  `charset` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '编码格式',
  `seller_email` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '卖家支付宝账号',
  `subject` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '订单标题',
  `sign` varchar(400) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '签名',
  `body` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '商品描述',
  `buyer_id` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '买家支付宝用户号',
  `invoice_amount` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '开票金额',
  `notify_id` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '通知校验ID',
  `fund_bill_list` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '支付金额信息',
  `notify_type` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '通知类型',
  `trade_status` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '交易状态',
  `receipt_amount` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '实收金额',
  `app_id` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '开发者的app_id',
  `buyer_pay_amount` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '付款金额',
  `sign_type` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '签名类型',
  `seller_id` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '卖家支付宝用户号',
  `gmt_payment` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '交易付款时间',
  `notify_time` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '通知时间',
  `version` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '接口版本',
  `total_amount` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '订单金额',
  `trade_no` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '支付宝交易号  ',
  `auth_app_id` varchar(100) CHARACTER SET utf8mb4 DEFAULT '',
  `buyer_logon_id` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '买家支付宝账号',
  `point_amount` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '集分宝金额',
  `channel` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '支付渠道',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ca_pay_alinotice
-- ----------------------------

-- ----------------------------
-- Table structure for ca_pay_wxnotice
-- ----------------------------
DROP TABLE IF EXISTS `ca_pay_wxnotice`;
CREATE TABLE `ca_pay_wxnotice` (
  `order_id` int(10) NOT NULL,
  `appid` varchar(30) CHARACTER SET utf8mb4 DEFAULT '',
  `attach` varchar(128) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '商家数据包 128位 原样返回',
  `customer_id` int(10) DEFAULT NULL COMMENT '该订单下单的客户ID',
  `bank_type` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '付款银行',
  `cash_fee` varchar(10) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '现金支付金额',
  `device_info` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '设备信息',
  `fee_type` varchar(10) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '货币种类',
  `is_subscribe` varchar(3) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '是否关注',
  `mch_id` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '商户ID',
  `nonce_str` varchar(50) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '随机字符串',
  `openid` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '支付用户ID',
  `out_trade_no` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '订单号',
  `result_code` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '结果状态',
  `return_code` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '返回状态',
  `sign` varchar(100) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '签名',
  `time_end` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '结束时间',
  `total_fee` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '订单总价、按分计算',
  `trade_type` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '交易类型',
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '微信支付订单号',
  `channel` varchar(30) CHARACTER SET utf8mb4 DEFAULT '' COMMENT '支付渠道',
  `add_time` int(10) DEFAULT '0' COMMENT '当前订单生成时间',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付订单，保存各种渠道的交易流水、交易订单信息等';

-- ----------------------------
-- Records of ca_pay_wxnotice
-- ----------------------------

-- ----------------------------
-- Table structure for ca_send
-- ----------------------------
DROP TABLE IF EXISTS `ca_send`;
CREATE TABLE `ca_send` (
  `send_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '送货单id',
  `merchant_id` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '供应商id',
  `supplier_uid` int(11) DEFAULT NULL COMMENT '供应商用户uid',
  `order_id` int(11) DEFAULT NULL COMMENT '来源于 供应商发布需求表',
  `publish_time` int(11) DEFAULT NULL COMMENT '发布时间',
  `maybe_time` int(11) DEFAULT NULL COMMENT '预计送达时间 （自动在发布时间后加60分钟）',
  `sand_remark` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '送货订单备注',
  `send_status` int(11) DEFAULT NULL COMMENT '订单状态 0 发布 20平台收到待分配送货者司机  40-送货者司机确认  60 - 司机已到达   80-司机已取货  100 司机送达目的地 120目的地商家确认收货 140 完成送货回到平台所在，送货整体完成',
  `pay_status` int(11) DEFAULT NULL COMMENT '支付状态 0 未支付 大于0具体为支付订单号 便于关联查询',
  `driver_uid` int(11) DEFAULT NULL COMMENT '司机uid',
  `driver_take_time` int(11) DEFAULT NULL COMMENT '司机取货时间',
  `driver_over_time` int(11) DEFAULT NULL COMMENT '司机送达货时间',
  `site_sn` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '记账凭证号，线下有个单子，单子的号码，取货的人填',
  PRIMARY KEY (`send_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='司机送货需求表，补充完善信息表';

-- ----------------------------
-- Records of ca_send
-- ----------------------------

-- ----------------------------
-- Table structure for ca_send_log
-- ----------------------------
DROP TABLE IF EXISTS `ca_send_log`;
CREATE TABLE `ca_send_log` (
  `log_id` int(11) NOT NULL,
  `send_id` int(11) DEFAULT NULL COMMENT '对应订单id',
  `send_status` int(255) DEFAULT NULL COMMENT '订单状态',
  `op_uid` int(11) DEFAULT NULL COMMENT '操作用户uid  根据status来判断是哪种uid 司机的uid 确认的uid',
  `log_time` datetime DEFAULT NULL COMMENT '时间',
  `log_msg` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '日志备注，专门针对这个环节的备注',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='司机送货需求表，状态变化日志表';

-- ----------------------------
-- Records of ca_send_log
-- ----------------------------

-- ----------------------------
-- Table structure for ca_user
-- ----------------------------
DROP TABLE IF EXISTS `ca_user`;
CREATE TABLE `ca_user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `realname` varchar(50) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名前后端登录唯一标识（系统内部动态生成）',
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT '用户的标识，对当前公众号唯一',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '前台显示的昵称',
  `wxname` varchar(100) NOT NULL COMMENT '微信用户的昵称',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',
  `city` varchar(100) NOT NULL DEFAULT '' COMMENT '用户所在城市',
  `country` varchar(100) NOT NULL DEFAULT '' COMMENT '用户所在国家',
  `province` varchar(100) NOT NULL DEFAULT '' COMMENT '用户所在省份',
  `language` varchar(50) NOT NULL COMMENT '用户的语言，简体中文为zh_CN',
  `subscribe_time` int(11) NOT NULL DEFAULT '0' COMMENT '用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间',
  `unionid` varchar(100) NOT NULL DEFAULT '' COMMENT '用户唯一标识（注：只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段）',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '公众号运营者对粉丝的备注，公众号运营者可在微信公众平台用户管理界面对粉丝添加备注',
  `groupid` varchar(100) NOT NULL DEFAULT '' COMMENT '用户所在的分组ID（兼容旧的用户分组接口）',
  `tagid_list` varchar(100) NOT NULL DEFAULT '' COMMENT '用户被打上的标签ID列表',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(10) NOT NULL DEFAULT '' COMMENT '密码salt',
  `regip` varchar(20) NOT NULL DEFAULT '' COMMENT '注册IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `login_num` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '用户类型（0：游客，1：后台管理员、2供应商用户，3取货者，4司机，5目的地商家用户）',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of ca_user
-- ----------------------------
INSERT INTO `ca_user` VALUES ('1', '创始人', 'admin', 'admin', '创始人', 'dorisnzy', '0', '', '', '', '', '0', '', '', '', '', 'cf57eb8a739adbcae3a7669e4a41ad5a', 'UFTGw', '', '1514856416', '127.0.0.1', '36', '1', '0', '1514856416', '18388069008', '915599781@qq.com');
INSERT INTO `ca_user` VALUES ('2', '', 'nongzhengyi', '', '农正忆', 'dorislsy', '1', '', '', '', '', '0', '', '', '', '', 'c60782f20eef3d9abd3fd8493b26ab6d', 'BROFzf', '127.0.0.1', '1514708513', '127.0.0.1', '7', '1', '1514566861', '1514708513', '18388092222', '915599781@qq.at');

-- ----------------------------
-- Table structure for ca_user_admin
-- ----------------------------
DROP TABLE IF EXISTS `ca_user_admin`;
CREATE TABLE `ca_user_admin` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0待审核、1正常、2锁定、3离职）',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `uid` (`uid`) USING BTREE COMMENT '会员uid不能重复'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

-- ----------------------------
-- Records of ca_user_admin
-- ----------------------------

-- ----------------------------
-- Table structure for ca_user_driver
-- ----------------------------
DROP TABLE IF EXISTS `ca_user_driver`;
CREATE TABLE `ca_user_driver` (
  `driver_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `work_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工作状态（0：休息，1：忙碌，3：停职）',
  PRIMARY KEY (`driver_id`),
  UNIQUE KEY `uid` (`uid`) USING BTREE COMMENT '会员ID唯一'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='司机用户表';

-- ----------------------------
-- Records of ca_user_driver
-- ----------------------------

-- ----------------------------
-- Table structure for ca_user_supplier
-- ----------------------------
DROP TABLE IF EXISTS `ca_user_supplier`;
CREATE TABLE `ca_user_supplier` (
  `supplier_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `merchant_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商家ID（注：与商家表ca_merchant关联）',
  PRIMARY KEY (`supplier_id`),
  UNIQUE KEY `uid` (`uid`) USING BTREE COMMENT '会员ID唯一'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='供应商用户表';

-- ----------------------------
-- Records of ca_user_supplier
-- ----------------------------
INSERT INTO `ca_user_supplier` VALUES ('1', '2', '1');

-- ----------------------------
-- Table structure for ca_user_take
-- ----------------------------
DROP TABLE IF EXISTS `ca_user_take`;
CREATE TABLE `ca_user_take` (
  `take_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `work_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工作状态（0：休息，1：忙碌，3：停职）',
  PRIMARY KEY (`take_id`),
  UNIQUE KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='取货者表';

-- ----------------------------
-- Records of ca_user_take
-- ----------------------------

-- ----------------------------
-- Table structure for ca_user_target
-- ----------------------------
DROP TABLE IF EXISTS `ca_user_target`;
CREATE TABLE `ca_user_target` (
  `target_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `merchant_id` int(11) NOT NULL DEFAULT '0' COMMENT '目的地商家ID（注：与商家表ca_merchant关联）',
  PRIMARY KEY (`target_id`),
  UNIQUE KEY `uid` (`uid`) USING BTREE COMMENT '会员唯一'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='目的地商家用户表';

-- ----------------------------
-- Records of ca_user_target
-- ----------------------------
