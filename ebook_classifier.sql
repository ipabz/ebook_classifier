/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50620
Source Host           : localhost:3306
Source Database       : ebook_classifier

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2015-02-09 21:22:10
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
-- Table structure for `ebook`
-- ----------------------------
DROP TABLE IF EXISTS `ebook`;
CREATE TABLE `ebook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` text CHARACTER SET latin1 NOT NULL,
  `classification` varchar(10) CHARACTER SET latin1 NOT NULL,
  `meta_data` text CHARACTER SET latin1,
  `tokens` text CHARACTER SET latin1,
  `corpus_count` text CHARACTER SET latin1,
  `removed_stop_words` text CHARACTER SET latin1,
  `tokens_count` text CHARACTER SET latin1,
  `bigram_raw` text CHARACTER SET latin1,
  `bigram_counted` text CHARACTER SET latin1,
  `final_tokens` text CHARACTER SET latin1,
  `date_created` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ebook
-- ----------------------------

-- ----------------------------
-- Table structure for `logs`
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text,
  `contents` text,
  `date` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES ('1', 'File Upload', 'Computer_Security_Art_and_Science (4).pdf', '838:59:59');
INSERT INTO `logs` VALUES ('2', 'File Upload', 'sample (2).pdf', '838:59:59');
INSERT INTO `logs` VALUES ('3', 'File Upload', 'sample (3).pdf', '838:59:59');
INSERT INTO `logs` VALUES ('4', 'File Upload', '[Michael_Huth,_Mark_Ryan]_Logic_in_computer_scienc(BookZZ.org)_.pdf', '838:59:59');

-- ----------------------------
-- Table structure for `training`
-- ----------------------------
DROP TABLE IF EXISTS `training`;
CREATE TABLE `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(20) NOT NULL,
  `item_raw` varchar(50) NOT NULL,
  `item_stemmed` varchar(50) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of training
-- ----------------------------
