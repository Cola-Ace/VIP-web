/*
 Navicat Premium Data Transfer

 Source Server         : muyea
 Source Server Type    : MySQL
 Source Server Version : 50728
 Source Host           : muyeaqwq.mysql.rds.aliyuncs.com:3306
 Source Schema         : rank

 Target Server Type    : MySQL
 Target Server Version : 50728
 File Encoding         : 65001

 Date: 19/12/2020 02:00:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for vip_web_user
-- ----------------------------
DROP TABLE IF EXISTS `vip_web_user`;
CREATE TABLE `vip_web_user`  (
  `user` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`user`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of vip_web_user
-- ----------------------------
INSERT INTO `vip_web_user` VALUES ('admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin');

SET FOREIGN_KEY_CHECKS = 1;
