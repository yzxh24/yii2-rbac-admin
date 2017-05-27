/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50635
 Source Host           : localhost
 Source Database       : yii2_rbac

 Target Server Type    : MySQL
 Target Server Version : 50635
 File Encoding         : utf-8

 Date: 05/27/2017 09:05:37 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `ig_auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `ig_auth_assignment`;
CREATE TABLE `ig_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `ig_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `ig_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户-角色的关联表';

-- ----------------------------
--  Records of `ig_auth_assignment`
-- ----------------------------
BEGIN;
INSERT INTO `ig_auth_assignment` VALUES ('文章更新员', '162', '1495640113'), ('超级管理员', '156', '1495640937'), ('超级管理员', '162', '1495640113');
COMMIT;

-- ----------------------------
--  Table structure for `ig_auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `ig_auth_item`;
CREATE TABLE `ig_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `ig_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `ig_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用于存储角色、权限和路由';

-- ----------------------------
--  Records of `ig_auth_item`
-- ----------------------------
BEGIN;
INSERT INTO `ig_auth_item` VALUES ('rbac/auth-menu/create', '2', null, null, null, '1495711121', '1495711121'), ('rbac/auth-menu/delete', '2', null, null, null, '1495711121', '1495711121'), ('rbac/auth-menu/index', '2', null, null, null, '1495711121', '1495711121'), ('rbac/auth-menu/update', '2', null, null, null, '1495711121', '1495711121'), ('rbac/auth-role/create', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-role/create-permissions', '2', null, null, null, '1495763440', '1495763440'), ('rbac/auth-role/delete', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-role/index', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-role/permissions', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-role/update', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-user/create', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-user/index', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-user/role', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-user/save-role', '2', null, null, null, '1495640361', '1495640361'), ('rbac/auth-user/update', '2', null, null, null, '1495640361', '1495640361'), ('rbac/site/index', '2', null, null, null, '1495639656', '1495639656'), ('rbac/site/login', '2', null, null, null, '1495639656', '1495639656'), ('rbac/site/logout', '2', null, null, null, '1495639665', '1495639665'), ('rbac/site/reset-password', '2', null, null, null, '1495782776', '1495782776'), ('文章更新员', '1', '负责网站文章更新', null, null, '1495637887', '1495642630'), ('超级管理员', '1', '超级管理员', null, null, '1495639939', '1495642611');
COMMIT;

-- ----------------------------
--  Table structure for `ig_auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `ig_auth_item_child`;
CREATE TABLE `ig_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `ig_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ig_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ig_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `ig_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='角色-权限的关联表';

-- ----------------------------
--  Records of `ig_auth_item_child`
-- ----------------------------
BEGIN;
INSERT INTO `ig_auth_item_child` VALUES ('超级管理员', 'rbac/auth-menu/create'), ('超级管理员', 'rbac/auth-menu/delete'), ('超级管理员', 'rbac/auth-menu/index'), ('超级管理员', 'rbac/auth-menu/update'), ('超级管理员', 'rbac/auth-role/create'), ('超级管理员', 'rbac/auth-role/create-permissions'), ('超级管理员', 'rbac/auth-role/delete'), ('超级管理员', 'rbac/auth-role/index'), ('超级管理员', 'rbac/auth-role/permissions'), ('超级管理员', 'rbac/auth-role/update'), ('超级管理员', 'rbac/auth-user/create'), ('超级管理员', 'rbac/auth-user/index'), ('超级管理员', 'rbac/auth-user/role'), ('超级管理员', 'rbac/auth-user/save-role'), ('超级管理员', 'rbac/auth-user/update'), ('文章更新员', 'rbac/site/index'), ('超级管理员', 'rbac/site/index'), ('文章更新员', 'rbac/site/login'), ('超级管理员', 'rbac/site/login'), ('文章更新员', 'rbac/site/logout'), ('超级管理员', 'rbac/site/logout'), ('文章更新员', 'rbac/site/reset-password'), ('超级管理员', 'rbac/site/reset-password');
COMMIT;

-- ----------------------------
--  Table structure for `ig_auth_menu`
-- ----------------------------
DROP TABLE IF EXISTS `ig_auth_menu`;
CREATE TABLE `ig_auth_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `ig_auth_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `ig_auth_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台菜单';

-- ----------------------------
--  Records of `ig_auth_menu`
-- ----------------------------
BEGIN;
INSERT INTO `ig_auth_menu` VALUES ('13', '权限管理', null, null, null, null), ('14', '菜单管理', '13', 'rbac/auth-menu/index', '1', null), ('15', '角色管理', '13', 'rbac/auth-role/index', '2', null), ('16', '用户管理', '13', 'rbac/auth-user/index', '3', null);
COMMIT;

-- ----------------------------
--  Table structure for `ig_auth_route`
-- ----------------------------
DROP TABLE IF EXISTS `ig_auth_route`;
CREATE TABLE `ig_auth_route` (
  `route` varchar(100) NOT NULL,
  `text` varchar(100) NOT NULL,
  KEY `idx_route` (`route`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='路由标签映射列表';

-- ----------------------------
--  Table structure for `ig_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `ig_auth_rule`;
CREATE TABLE `ig_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='权限规则表';

-- ----------------------------
--  Table structure for `ig_auth_user`
-- ----------------------------
DROP TABLE IF EXISTS `ig_auth_user`;
CREATE TABLE `ig_auth_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL COMMENT '用户名',
  `password` varchar(200) NOT NULL COMMENT '密码',
  `auth_key` varchar(50) DEFAULT NULL COMMENT '自动登录key',
  `last_ip` varchar(50) DEFAULT NULL COMMENT '最近一次登录ip',
  `is_online` char(1) DEFAULT 'n' COMMENT '是否在线',
  `domain_account` varchar(100) DEFAULT NULL COMMENT '域账号',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `create_user` varchar(100) NOT NULL COMMENT '创建人',
  `create_date` datetime NOT NULL COMMENT '创建时间',
  `update_user` varchar(101) NOT NULL COMMENT '更新人',
  `update_date` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台帐号表';

-- ----------------------------
--  Records of `ig_auth_user`
-- ----------------------------
BEGIN;
INSERT INTO `ig_auth_user` VALUES ('156', 'admin', '$2y$13$T.jKXzcQV58sSS1u322CLujY4PsjYfmH/QCkRRoQvpld/.YkDaKD6', null, 'Unknown', 'n', '', '10', 'admin', '2014-07-07 00:05:47', 'admin', '2017-05-26 16:10:23'), ('158', 'test', '$2y$13$9O6bKJieocg//oSax9fZOOuljAKarBXknqD8.RyYg60FfNjS7SoqK', null, '', 'n', '', '10', 'admin', '2014-09-03 12:19:52', 'admin', '2017-05-19 19:48:26');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
