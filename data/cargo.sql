/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : cargo

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-25 18:24:30
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

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
-- Table structure for ca_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `ca_auth_rule`;
CREATE TABLE `ca_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(120) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '为1正常，为0禁用',
  `group_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '权限组，配置中定义',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ca_menu
-- ----------------------------
DROP TABLE IF EXISTS `ca_menu`;
CREATE TABLE `ca_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单节点',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '菜单类型（1：主菜单，2：节点菜单）',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `rule_id` int(11) NOT NULL COMMENT '权限节点id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0-禁用 1-启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Table structure for ca_user
-- ----------------------------
DROP TABLE IF EXISTS `ca_user`;
CREATE TABLE `ca_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `name` varchar(50) DEFAULT NULL COMMENT '用户名（用于登录）',
  `real_name` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱（用于登录）',
  `password` varchar(50) DEFAULT NULL COMMENT '登录密码',
  `reg_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `reg_ip` varchar(20) DEFAULT NULL COMMENT '注册IP',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  `xy_id` int(11) DEFAULT NULL COMMENT '翔宇用户ID',
  `xy_name` varchar(100) DEFAULT NULL COMMENT '翔宇用户名',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态（-1：删除，0：禁用，1：正常）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户表';
