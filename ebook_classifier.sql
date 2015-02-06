/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50620
Source Host           : localhost:3306
Source Database       : ebook_classifier

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2015-02-06 12:30:43
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
-- Table structure for `logs`
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text,
  `contents` text,
  `date` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES ('122', 'File Upload', '{\"scalar\":\"\"}', '838:59:59');
INSERT INTO `logs` VALUES ('123', 'File Upload', '{\"0\":{\"name\":\"Advanced PHP Programming (17).pdf\",\"size\":16638303,\"type\":\"application\\/pdf\",\"url\":\"http:\\/\\/localhost\\/ebook_classifier\\/server\\/php\\/files\\/Advanced%20PHP%20Programming%20%2817%29.pdf\",\"deleteUrl\":\"http:\\/\\/localhost\\/ebook_classifier\\/server\\/php\\/?file=Advanced%20PHP%20Programming%20%2817%29.pdf\",\"deleteType\":\"DELETE\"}}', '838:59:59');
INSERT INTO `logs` VALUES ('124', 'File Upload', '{\"scalar\":\"\"}', '838:59:59');
INSERT INTO `logs` VALUES ('125', 'File Upload', '{\"name\":\"Advanced PHP Programming (18).pdf\",\"size\":16638303,\"type\":\"application\\/pdf\",\"url\":\"http:\\/\\/localhost\\/ebook_classifier\\/server\\/php\\/files\\/Advanced%20PHP%20Programming%20%2818%29.pdf\",\"deleteUrl\":\"http:\\/\\/localhost\\/ebook_classifier\\/server\\/php\\/?file=Advanced%20PHP%20Programming%20%2818%29.pdf\",\"deleteType\":\"DELETE\"}', '838:59:59');
INSERT INTO `logs` VALUES ('126', 'File Upload', 'Advanced PHP Programming (19).pdf', '838:59:59');
INSERT INTO `logs` VALUES ('127', 'File Upload', '[Wu_X.,_Kumar_V._(eds.)]_The_Top_Ten_Algorithms_in(BookZZ.org).pdf', '838:59:59');
INSERT INTO `logs` VALUES ('128', 'File Upload', '[Wu_X.,_Kumar_V._(eds.)]_The_Top_Ten_Algorithms_in(BookZZ.org) (1).pdf', '838:59:59');
INSERT INTO `logs` VALUES ('129', 'File Upload', '[Wu_X.,_Kumar_V._(eds.)]_The_Top_Ten_Algorithms_in(BookZZ.org) (2).pdf', '838:59:59');
INSERT INTO `logs` VALUES ('130', 'File Upload', '[Wu_X.,_Kumar_V._(eds.)]_The_Top_Ten_Algorithms_in(BookZZ.org) (3).pdf', '838:59:59');
INSERT INTO `logs` VALUES ('131', 'File Upload', 'Computer Science - Network and Networking Programming .pdf', '838:59:59');
INSERT INTO `logs` VALUES ('132', 'File Upload', 'Advanced PHP Programming.pdf', '838:59:59');
INSERT INTO `logs` VALUES ('133', 'File Upload', 'Computer Graphics - Principles and Practice 3rd Edition.pdf', '838:59:59');
INSERT INTO `logs` VALUES ('134', 'File Upload', 'Computer Science - AI - Artificial Intelligence Programming.pdf', '838:59:59');
INSERT INTO `logs` VALUES ('135', 'File Upload', 'Computer_Security_Art_and_Science.pdf', '838:59:59');
INSERT INTO `logs` VALUES ('136', 'File Upload', 'Data_Mining _3rd.pdf', '838:59:59');
INSERT INTO `logs` VALUES ('137', 'File Upload', 'Computer Science - AI - Artificial Intelligence Programming.pdf', '838:59:59');
INSERT INTO `logs` VALUES ('138', 'File Upload', 'Computer_Security_Art_and_Science.pdf', '838:59:59');

-- ----------------------------
-- Table structure for `training`
-- ----------------------------
DROP TABLE IF EXISTS `training`;
CREATE TABLE `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` text NOT NULL,
  `classification` varchar(10) NOT NULL,
  `tokens` text,
  `corpus_count` text,
  `removed_stop_words` text,
  `tokens_count` text,
  `date_created` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of training
-- ----------------------------
