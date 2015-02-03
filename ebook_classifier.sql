/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50620
Source Host           : localhost:3306
Source Database       : ebook_classifier

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2015-02-03 19:04:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `classifications`
-- ----------------------------
DROP TABLE IF EXISTS `classifications`;
CREATE TABLE `classifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(100) NOT NULL,
  `dictionary_file` varchar(255) NOT NULL,
  `date_created` text NOT NULL,
  `last_updated` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of classifications
-- ----------------------------
INSERT INTO `classifications` VALUES ('1', '004', 'class004.txt', '1421217656', '1421217656');
INSERT INTO `classifications` VALUES ('2', '005', 'class005.txt', '1421217656', '1421217656');
INSERT INTO `classifications` VALUES ('3', '006', 'class006.txt', '1421217656', '1421217656');

-- ----------------------------
-- Table structure for `training`
-- ----------------------------
DROP TABLE IF EXISTS `training`;
CREATE TABLE `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` text NOT NULL,
  `classification` varchar(10) NOT NULL,
  `tokens` text,
  `tokens_count` text,
  `date_created` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of training
-- ----------------------------
