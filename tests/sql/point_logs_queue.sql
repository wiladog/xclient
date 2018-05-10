/*
 Navicat Premium Data Transfer

 Source Server         : Wilaserv
 Source Server Type    : MySQL
 Source Server Version : 50720
 Source Host           : 192.168.33.10:3306
 Source Schema         : xgold_infinix_dev

 Target Server Type    : MySQL
 Target Server Version : 50720
 File Encoding         : 65001

 Date: 12/03/2018 14:54:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for point_logs_queue
-- ----------------------------
DROP TABLE IF EXISTS `point_logs_queue`;
CREATE TABLE `point_logs_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `related` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

SET FOREIGN_KEY_CHECKS = 1;
