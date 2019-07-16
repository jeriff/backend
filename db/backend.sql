/*
Navicat MySQL Data Transfer

Source Server         : 192.168.78.56
Source Server Version : 50627
Source Host           : 192.168.78.56:3306
Source Database       : backend

Target Server Type    : MYSQL
Target Server Version : 50627
File Encoding         : 65001

Date: 2019-07-16 19:17:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for file_log
-- ----------------------------
DROP TABLE IF EXISTS `file_log`;
CREATE TABLE `file_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(200) NOT NULL COMMENT '新生成的文件名',
  `name` varchar(200) NOT NULL COMMENT '文件原名',
  `uid` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文件上传日志';

-- ----------------------------
-- Records of file_log
-- ----------------------------
INSERT INTO `file_log` VALUES ('1', '15632615337472252967.jpg', '微信图片_20190715173633.jpg', '1', 'admin_test', '2019-07-16 07:18:53');
INSERT INTO `file_log` VALUES ('2', '15632628571581160210.jpg', '微信图片_20190715173633.jpg', '1', 'admin_test', '2019-07-16 07:40:57');
INSERT INTO `file_log` VALUES ('3', '15632630544160039073.jpg', '微信图片_20190715173633.jpg', '1', 'admin_test', '2019-07-16 15:44:14');

-- ----------------------------
-- Table structure for login_log
-- ----------------------------
DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `login_time` datetime NOT NULL,
  `login_res` int(11) NOT NULL DEFAULT '1' COMMENT '登录结果 1 成功 二失败',
  `data` text COMMENT '请求数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志';

-- ----------------------------
-- Records of login_log
-- ----------------------------

-- ----------------------------
-- Table structure for login_user
-- ----------------------------
DROP TABLE IF EXISTS `login_user`;
CREATE TABLE `login_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='站点登录用户';

-- ----------------------------
-- Records of login_user
-- ----------------------------
INSERT INTO `login_user` VALUES ('1', 'admin_test', 'b44adf2692a29a454140b7dc9f0c03e4');

-- ----------------------------
-- Table structure for operate_log
-- ----------------------------
DROP TABLE IF EXISTS `operate_log`;
CREATE TABLE `operate_log` (
  `id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `data` text NOT NULL COMMENT '请求内容',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- ----------------------------
-- Records of operate_log
-- ----------------------------

-- ----------------------------
-- Table structure for pgc
-- ----------------------------
DROP TABLE IF EXISTS `pgc`;
CREATE TABLE `pgc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `cover` varchar(500) NOT NULL COMMENT '封面',
  `uid` int(11) NOT NULL COMMENT '用户编码',
  `uname` varchar(50) NOT NULL COMMENT '用户名',
  `content` varchar(2000) NOT NULL COMMENT '文案',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1 上线 2 下线',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pgc
-- ----------------------------

-- ----------------------------
-- Table structure for pgc_source
-- ----------------------------
DROP TABLE IF EXISTS `pgc_source`;
CREATE TABLE `pgc_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pgc_id` int(11) NOT NULL,
  `source` varchar(200) DEFAULT NULL COMMENT '资源地址',
  `sort` tinyint(4) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pgc_source
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `gender` tinyint(4) DEFAULT '1' COMMENT '性别 1 女 2 男',
  `avater` varchar(200) DEFAULT NULL COMMENT '头像',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1 启用 2 禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '李四', '1', '15632615337472252967.jpg', '1', null);
INSERT INTO `user` VALUES ('2', '王五', '1', '15632615337472252967.jpg', '1', '2019-07-16 18:28:59');
