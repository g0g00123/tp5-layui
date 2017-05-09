/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : weibo

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-05-08 08:34:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for think_admin
-- ----------------------------
DROP TABLE IF EXISTS `think_admin`;
CREATE TABLE `think_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `last_login_time` datetime DEFAULT NULL,
  `login_ip` varchar(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_admin
-- ----------------------------
INSERT INTO `think_admin` VALUES ('4', 'spicy', '123456', null, 'ddd', '0', '1970-01-01 08:00:00', null, null, '2017-04-07 18:06:15', '2017-04-12 08:52:05');
INSERT INTO `think_admin` VALUES ('23', 'admin', '21232f297a57a5a743894a0e4a801fc3', null, '58e7649635f34_thumb.tmp', '1', null, null, null, '2017-04-07 18:06:15', '2017-04-07 18:06:15');

-- ----------------------------
-- Table structure for think_comment
-- ----------------------------
DROP TABLE IF EXISTS `think_comment`;
CREATE TABLE `think_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `from_user_id` int(11) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_comment
-- ----------------------------
INSERT INTO `think_comment` VALUES ('1', '39', '1', '测试中', '1', '2', '2017-04-12 15:07:47', '2017-04-12 15:07:50');
INSERT INTO `think_comment` VALUES ('2', '39', '1', 'test', '1', '1', '2017-04-12 15:21:18', '2017-04-12 15:21:19');

-- ----------------------------
-- Table structure for think_post
-- ----------------------------
DROP TABLE IF EXISTS `think_post`;
CREATE TABLE `think_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL DEFAULT '1',
  `content` longtext NOT NULL,
  `title` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `comment_status` varchar(20) NOT NULL,
  `comment_count` bigint(20) DEFAULT '0',
  `keep` tinyint(5) DEFAULT NULL,
  `like` tinyint(5) DEFAULT NULL,
  `feature_image` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=175 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_post
-- ----------------------------
INSERT INTO `think_post` VALUES ('1', '1', '天气这么好，一起去散步吧', '', '0', 'close', '0', null, '11', null, '2017-04-10 10:30:44', '2017-05-06 13:47:10');
INSERT INTO `think_post` VALUES ('2', '1', '你在说神马，我听不到', '', '0', 'on', '0', null, null, null, '2016-04-10 10:36:25', '2017-04-10 10:31:15');
INSERT INTO `think_post` VALUES ('3', '2', '吹啊吹啊我的骄傲放纵', '', '0', 'on', '0', null, null, null, '2016-04-10 10:36:25', '2017-04-10 10:32:38');
INSERT INTO `think_post` VALUES ('4', '1', 'PPAP', '', '0', 'open', '0', null, null, null, '2016-02-18 10:33:22', '2017-04-10 10:33:22');
INSERT INTO `think_post` VALUES ('5', '1', '扎心了老铁', '', '0', 'on', '0', null, null, null, '2017-04-10 10:33:51', '2017-04-10 10:33:51');

-- ----------------------------
-- Table structure for think_role
-- ----------------------------
DROP TABLE IF EXISTS `think_role`;
CREATE TABLE `think_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) DEFAULT NULL,
  `desc` varchar(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `sign` varchar(50) DEFAULT NULL COMMENT '1.添加管理员2.删除管理员3.编辑管理员4.删除用户5.发表文章',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_role
-- ----------------------------
INSERT INTO `think_role` VALUES ('1', '超级管理员', '操作所有菜单', '0', '1,2,3,4,5', '2017-04-18 09:38:16', '2017-04-19 10:45:07');
INSERT INTO `think_role` VALUES ('2', '管理员', '操作用户菜单', '0', '1,2,4', '2017-04-18 10:32:25', '2017-04-19 11:07:40');

-- ----------------------------
-- Table structure for think_user
-- ----------------------------
DROP TABLE IF EXISTS `think_user`;
CREATE TABLE `think_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `sex` varchar(2) DEFAULT NULL COMMENT '1.男，2.女',
  `mobile` varchar(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `motto` varchar(255) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `province` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_user
-- ----------------------------

INSERT INTO `think_user` VALUES ('1', 'spicy', 'spicy', 'e10adc3949ba59abbe56e057f20f883e', '2', '18380448456', '58ff5afe15be8_thumb.tmp', 'times wait no one', null, '北京', '0', '2017-04-08 15:26:28', '2017-04-25 22:19:42');
