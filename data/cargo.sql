/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : cargo

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-28 01:12:10
*/

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ca_auth_group_access
-- ----------------------------
INSERT INTO `ca_auth_group_access` VALUES ('8', '3');
INSERT INTO `ca_auth_group_access` VALUES ('8', '4');
INSERT INTO `ca_auth_group_access` VALUES ('13', '1');
INSERT INTO `ca_auth_group_access` VALUES ('14', '1');
INSERT INTO `ca_auth_group_access` VALUES ('15', '1');

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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
INSERT INTO `ca_menu` VALUES ('2', '用户', 'admin/user/index', 'admin', '系统管理', '2', null, '1', '100', '1');
INSERT INTO `ca_menu` VALUES ('3', '角色', 'admin/group/index', 'admin', '系统管理', '2', null, '1', '100', '1');
INSERT INTO `ca_menu` VALUES ('4', '菜单', 'admin/menu/index', 'admin', '系统管理', '2', null, '1', '100', '1');
INSERT INTO `ca_menu` VALUES ('6', '权限', 'admin/rule/index', 'admin', '系统管理', '2', null, '1', '100', '1');
INSERT INTO `ca_menu` VALUES ('7', '首页', 'admin/index/index', 'admin', '其它', '1', null, '0', '1', '1');

-- ----------------------------
-- Table structure for ca_user
-- ----------------------------
DROP TABLE IF EXISTS `ca_user`;
CREATE TABLE `ca_user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '真实姓名',
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '密码',
  `isadministrator` tinyint(2) NOT NULL DEFAULT '0' COMMENT '管理员id标识: 0为非管理员，1为管理员',
  `gender` tinyint(2) NOT NULL DEFAULT '0' COMMENT '性别：(0保密，1男,2女)',
  `mobile` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '手机号',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `tel` varchar(20) NOT NULL DEFAULT '' COMMENT 'tel',
  `weixin` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '微信号',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '头像',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态（0待审核、1正常、2锁定、3离职）',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `salt` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码salt',
  `guid` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '用户唯一id',
  `remark` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '备注说明',
  `regip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '注册IP',
  `last_login_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `login` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `extattr` text NOT NULL,
  `work_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工作状态（0：空闲，1：忙碌）',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user_name` (`username`) USING BTREE,
  UNIQUE KEY `mobile` (`mobile`) USING BTREE,
  UNIQUE KEY `email` (`email`) USING BTREE,
  UNIQUE KEY `weixin` (`weixin`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ca_user
-- ----------------------------
INSERT INTO `ca_user` VALUES ('1', 'admin', '创始人', 'cf57eb8a739adbcae3a7669e4a41ad5a', '1', '1', '13667792110', 'admin@admin.com', '', 'admin', '', '1', '0', '0', '1514381279', 'UFTGw', '', 0x61646D696E, '', '127.0.0.1', '1514381279', '13', '', '0');
INSERT INTO `ca_user` VALUES ('13', 'nongzhengyi', 'nongzhengyi', '4d1b77e5a85cadf095fc9ce447324ab6', '1', '1', '18345152222', 'sdf@sdfds.com', '', 'sdjojojoo', '', '1', '0', '1514353683', '1514376972', 'iRopO', '', '', '127.0.0.1', '127.0.0.1', '1514376972', '7', '', '0');
INSERT INTO `ca_user` VALUES ('14', 'test', 'test', '6e6f925a9d56ec6874cbfc9058bb882e', '1', '0', '234', 'sdf@fdsf.com', '', 'dsjfksajdf', '', '1', '0', '1514355803', '1514356028', 'FXCBw', '', 0x73616466647366, '127.0.0.1', '', '0', '0', '', '0');
INSERT INTO `ca_user` VALUES ('15', 'test1', 'test2', '0e3f3017fcc3332f1e7a6d4559532f87', '1', '0', 'test1', 'sadf@sdf.com', '', 'sadf', '', '1', '0', '1514356082', '1514356082', 'DgyHnk', '', '', '127.0.0.1', '', '0', '0', '', '0');
