/*
 Navicat Premium Data Transfer

 Source Server         : optiplex-taula
 Source Server Type    : MySQL
 Source Server Version : 50552
 Source Host           : 10.228.132.82
 Source Database       : metaDB

 Target Server Type    : MySQL
 Target Server Version : 50552
 File Encoding         : utf-8

 Date: 10/03/2016 16:58:35 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `metadb_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_attributes`;
CREATE TABLE `metadb_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `caption` varchar(200) NOT NULL DEFAULT '',
  `description` text,
  `type` enum('X','S','A','D','N','U','I','L','F','P','R','T','G','C','M','Z') NOT NULL DEFAULT 'X',
  `lookup_id` int(11) DEFAULT NULL,
  `width` int(3) DEFAULT NULL,
  `height` int(3) DEFAULT NULL,
  `max_length` int(11) DEFAULT '0',
  `img_width` int(3) DEFAULT NULL,
  `img_height` int(3) DEFAULT NULL,
  `enabled` varchar(1) NOT NULL,
  `tag` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `metadb_entities`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_entities`;
CREATE TABLE `metadb_entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` text,
  `caption` varchar(200) NOT NULL DEFAULT '',
  `grp_id` int(11) NOT NULL DEFAULT '1',
  `grp_order` int(11) DEFAULT NULL,
  `enabled` varchar(1) NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `metadb_entity_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_entity_attributes`;
CREATE TABLE `metadb_entity_attributes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) unsigned NOT NULL DEFAULT '0',
  `atri_id` int(11) DEFAULT '0',
  `rel_id` int(11) unsigned DEFAULT '0',
  `position_row` int(3) unsigned DEFAULT '0',
  `position_column` int(3) unsigned DEFAULT '0',
  `width` int(3) DEFAULT NULL,
  `height` int(3) DEFAULT NULL,
  `img_width` int(3) DEFAULT NULL,
  `img_height` int(3) DEFAULT NULL,
  `caption_position` enum('left','above') DEFAULT 'left',
  `order_key` int(10) unsigned DEFAULT NULL,
  `mandatory` enum('Y','N') NOT NULL DEFAULT 'N',
  `enabled` varchar(1) NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `metadb_class_attributes_n1` (`entity_id`) USING BTREE,
  KEY `metadb_class_attributes_n2` (`atri_id`) USING BTREE,
  KEY `metadb_class_attributes_n3` (`rel_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `metadb_entity_groups`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_entity_groups`;
CREATE TABLE `metadb_entity_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(200) NOT NULL DEFAULT '',
  `ordering` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `metadb_instances`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_instances`;
CREATE TABLE `metadb_instances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL DEFAULT '0',
  `key_fields` varchar(250) DEFAULT NULL,
  `status` enum('P','V','O') NOT NULL DEFAULT 'P',
  `publishing_begins` datetime DEFAULT NULL,
  `publishing_ends` datetime DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entity_id` (`entity_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `metadb_lookups`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_lookups`;
CREATE TABLE `metadb_lookups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `type` enum('L','R','C') CHARACTER SET latin1 NOT NULL DEFAULT 'L',
  `default_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `metadb_lookups_values`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_lookups_values`;
CREATE TABLE `metadb_lookups_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lookup_id` int(11) NOT NULL DEFAULT '0',
  `ordre` int(11) NOT NULL DEFAULT '0',
  `value` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `caption` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `metadb_relations`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_relations`;
CREATE TABLE `metadb_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `caption` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `parent_entity_id` int(11) NOT NULL DEFAULT '0',
  `child_entity_id` int(11) NOT NULL DEFAULT '0',
  `order_type` enum('M','T') NOT NULL DEFAULT 'M',
  `tag` varchar(50) NOT NULL,
  `enabled` varchar(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `metadb_relations_n1` (`parent_entity_id`) USING BTREE,
  KEY `metadb_relations_n2` (`child_entity_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `metadb_values`
-- ----------------------------
DROP TABLE IF EXISTS `metadb_values`;
CREATE TABLE `metadb_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) NOT NULL DEFAULT '0',
  `atri_id` int(11) NOT NULL DEFAULT '0',
  `text_val` text,
  `date_val` datetime DEFAULT NULL,
  `num_val` double DEFAULT NULL,
  `img_info` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `metadb_values_n1` (`entity_id`,`atri_id`) USING BTREE,
  KEY `metadb_values_n2` (`date_val`) USING BTREE,
  KEY `Text_Search` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
