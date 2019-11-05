/*
 Navicat MySQL Data Transfer

 Source Server         : myconnection
 Source Server Type    : MariaDB
 Source Server Version : 100316
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MariaDB
 Target Server Version : 100316
 File Encoding         : 65001

 Date: 18/09/2019 09:23:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_userlists
-- ----------------------------
DROP TABLE IF EXISTS `tbl_userlists`;
CREATE TABLE `tbl_userlists`  (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gender` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_userlists
-- ----------------------------
INSERT INTO `tbl_userlists` VALUES (1, 'sdsd', 'erwr');
INSERT INTO `tbl_userlists` VALUES (2, 'ioipi', 'kljlkj');

SET FOREIGN_KEY_CHECKS = 1;
