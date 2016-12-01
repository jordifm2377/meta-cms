/*
 Navicat Premium Data Transfer

 Source Server         : test-cms
 Source Server Type    : MySQL
 Source Server Version : 50715
 Source Host           : localhost
 Source Database       : metaCatalog

 Target Server Type    : MySQL
 Target Server Version : 50715
 File Encoding         : utf-8

 Date: 11/16/2016 22:55:49 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `metadb_attributes`
-- ----------------------------
BEGIN;
INSERT INTO `metadb_attributes` VALUES ('3', 'itg_id', 'Integrity Id', 'Generic ID for integrity to keep track of the original IDs', 'N', '0', '50', '50', '50', '0', '0', 'Y', 'integrityId'), ('4', 'itg_name', 'Integrity Name', 'Generic name for integrity', 'S', '0', '100', '15', '200', '0', '0', 'Y', 'integrityName'), ('5', 'itg_comments', 'Integrity Comments', 'Generic comments for integry', 'T', '0', '50', '50', '5000', '0', '0', 'Y', 'integrityComments'), ('7', 'itg_preferred_term_code', 'Integrity preferred term code', 'Preferred term code for integrity (unique for MDRA)', 'S', '0', '100', '15', '150', '0', '0', 'Y', 'integrityPrefTermCode'), ('8', 'isis_structure', 'Isis structure', 'Isis Structure', 'T', null, '50', '50', '5000', null, null, 'Y', 'isisStructure'), ('9', 'mol_weight', 'Molecular weight', 'Molecular weight', 'N', null, '50', '50', '50', null, null, 'Y', 'molecularStructure'), ('10', 'itg_physical_properties', 'Physical properties', 'Physical properties', 'S', null, '50', '50', '50', null, null, 'Y', 'integrityPhysicalProperties'), ('11', 'itg_year_phase', 'Year phase', 'Year phase', 'S', null, '50', '50', '50', null, null, 'Y', 'integrityYearPhase'), ('12', 'itg_star', 'Star', 'Star', 'L', '1', '0', '0', '0', null, null, 'Y', 'integrityStar'), ('13', 'itg_nme', 'NME', 'NME', 'S', null, '50', '50', '50', null, null, 'Y', 'integrityNME'), ('14', 'itg_nme_date', 'NME date', 'NME date', 'D', null, '50', '50', '50', null, null, 'Y', 'integrityNMEDate'), ('15', 'itg_base_mol_formula', 'Base molecular formula', 'Base molecular formula', 'T', null, '50', '50', '5000', null, null, 'Y', 'integrityBaseMolFormula'), ('16', 'itg_real_mol_formula', 'Real molecular formula', 'Real molecular formula', 'T', null, '50', '50', '5000', null, null, 'Y', 'integrityRealMolFormula'), ('17', 'itg_approx_mol_formula', 'Approximate molecular formula', 'Approximate molecular formula', 'T', null, '50', '50', '5000', null, null, 'Y', 'integrityApproxMolFormula'), ('18', 'itg_pro_genomics', 'Genomics', 'Genomics', 'S', null, '50', '50', '50', null, null, 'Y', 'integrityProGenomics'), ('19', 'itg_mol_interaction', 'Molecular interaction', 'Molecular interaction', 'T', null, '50', '50', '5000', null, null, 'Y', 'integrityMolInteraction'), ('20', 'itg_pro_regeneration', 'Regeneration', 'Regeneration', 'S', null, '50', '50', '50', null, null, 'Y', 'integrityProRegeneration'), ('21', 'itg_lipinski', 'Lipinski', 'Lipinski', 'S', null, '50', '50', '50', null, null, 'Y', 'integrityLipinski'), ('22', 'itg_economic_notes', 'Economic notes', 'Economic notes', 'T', null, '50', '50', '5000', null, null, 'Y', 'integrityEconomicNotes'), ('23', 'short_description', 'Short description', 'Short description', 'T', null, '50', '50', '5000', null, null, 'Y', 'shortDescription'), ('24', 'description', 'Description', 'Description', 'T', null, '50', '50', '5000', null, null, 'Y', 'description'), ('25', 'itg_year_flag', 'Year flag', 'Year flag', 'S', null, '50', '50', '50', null, null, 'Y', 'integrityYearFlag'), ('26', 'order', 'Order', 'Order', 'N', null, '50', '50', '50', null, null, 'Y', 'order'), ('27', 'itg_cas_no', 'CAS number', 'CAS number', 'S', null, '50', '50', '50', null, null, 'Y', 'integrityCASNumber'), ('28', 'validated', 'Validated', 'Validated', 'L', '1', '0', '0', '0', null, null, 'Y', 'validated'), ('29', 'itg_is_from_synth', 'Is from synth migration', 'Is from synth migration', 'L', '1', '0', '0', '0', null, null, 'Y', 'itgFromSynth'), ('30', 'itg_inchi', 'Inchi', 'Inchi', 'T', null, '50', '50', '5000', null, null, 'Y', 'itgInchi'), ('31', 'itg_inchi_key', 'Inchi key', 'Inchi key', 'S', null, '50', '50', '50', null, null, 'Y', 'itgInchiKey'), ('32', 'itg_url', 'Web address', 'Web address', 'S', null, '50', '50', '50', null, null, 'Y', 'itgUrl'), ('33', 'itg_accesion_no', 'Accesion number', 'Accesion number', 'S', null, '50', '50', '50', null, null, 'Y', 'itgAccesionNumber'), ('34', 'itg_milestone_year', 'Milestone year', 'Milestone year', 'S', null, '50', '50', '50', null, null, 'Y', 'itgMilestoneYear'), ('35', 'itg_milestone_month', 'Milestone month', 'Milestone month', 'S', null, '50', '50', '50', null, null, 'Y', 'itgMilestoneMonth'), ('36', 'itg_milestone_day', 'Milestone day', 'Milestone day', 'S', null, '50', '50', '50', null, null, 'Y', 'itgMilestoneDay'), ('37', 'itg_scheduled', 'Scheduled', 'Scheduled', 'S', null, '50', '50', '50', null, null, 'Y', 'itgScheduled'), ('38', 'itg_sched_on_date', 'Scheduled on date', 'Schedule on date', 'D', null, '50', '50', '50', null, null, 'Y', 'itgSchedOnDate'), ('39', 'itg_milestone_factsheet', 'Milestone fact sheet', 'Milestone fact sheet', 'S', null, '50', '50', '50', null, null, 'Y', 'itgMilestoneFactSheet'), ('40', 'itg_is_selected_for_history', 'Is selected for history', 'Is selected for history', 'L', '1', null, null, '0', null, null, 'Y', 'itgSelectedForHistory'), ('41', 'itg_discontinued', 'Discontinued', 'Discontinued', 'L', '1', null, null, '0', null, null, 'Y', 'itgDiscontinued'), ('44', 'itg_pt_code', 'PT Code', 'PT Code', 'S', null, '50', '50', '50', null, null, 'Y', 'itgPTCode');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `metadb_entities`
-- ----------------------------
BEGIN;
INSERT INTO `metadb_entities` VALUES ('3', 'itg_disease', 'master of diseases', 'Disease', '1', '0', 'Y', 'itgDisease'), ('4', 'itg_meddra', 'Auxiliary entity for MedDRA', 'MedDRA', '2', '0', 'Y', 'itgMedDra'), ('5', 'itg_synonym', 'Auxiliary entity for synonyms', 'Synonym', '2', '0', 'Y', 'itgSynonym'), ('6', 'genericM2M', 'Generic M to M entity', 'Generic M to M entity', '2', '0', 'Y', 'genericM2M'), ('7', 'itg_drug', 'Integrity Drug', 'Integrity Drug', '1', '0', 'Y', 'itgDrug'), ('8', 'itg_phase', 'Dev. phase', 'Dev. phase', '2', '0', 'Y', 'itgPhase'), ('9', 'itg_cas_number', 'CAS Number', 'CAS Number', '2', '0', 'Y', 'itgCasNum'), ('10', 'itg_inchi', 'Inchi', 'Inchi', '2', '0', 'Y', 'itgInchi'), ('11', 'itg_database', 'Database', 'Database', '2', '0', 'Y', 'itgDatabase'), ('12', 'itg_accesion_number', 'Accession number', 'Accession number', '2', '0', 'Y', 'itgAccessionNum'), ('13', 'itg_drug_milestone', 'Drug milestone', 'Drug milestone', '2', '0', 'Y', 'itgDrugMilestone'), ('14', 'itg_dev_status', 'Dev. status', 'Dev. status', '2', '0', 'Y', 'itgDevStatus'), ('15', 'itg_chem_name', 'Chemical name', 'Chemical name', '2', '0', 'Y', 'itgChemName'), ('16', 'itg_milestone', 'Milestone', 'Milestone', '1', '0', 'Y', 'itgMilestone');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `metadb_entity_attributes`
-- ----------------------------
BEGIN;
INSERT INTO `metadb_entity_attributes` VALUES ('5', '3', '3', '0', '1', '1', '0', '0', '0', '0', 'left', '1', 'Y', 'Y', null), ('6', '3', '4', '0', '1', '2', '0', '0', '0', '0', 'left', '2', 'Y', 'Y', null), ('7', '3', '5', '0', '2', '1', '0', '0', '0', '0', 'left', '0', 'N', 'Y', null), ('8', '3', '7', '0', '2', '2', '0', '0', '0', '0', 'left', '0', 'N', 'Y', null), ('9', '3', '0', '2', '3', '1', '0', '0', '0', '0', 'left', '0', 'N', 'Y', null), ('10', '3', '0', '3', '3', '2', '0', '0', '0', '0', 'left', '0', 'N', 'Y', null), ('11', '3', '0', '4', '4', '1', '0', '0', '0', '0', 'left', '0', 'N', 'Y', null), ('12', '7', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('13', '7', '8', '0', '1', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('14', '7', '9', '0', '2', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('15', '7', '10', '0', '2', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('16', '7', '11', '0', '3', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('17', '7', '12', '0', '3', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('18', '7', '13', '0', '4', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('19', '7', '14', '0', '4', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('20', '7', '15', '0', '5', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('21', '7', '16', '0', '5', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('22', '7', '17', '0', '6', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('23', '7', '18', '0', '6', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('24', '7', '19', '0', '7', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('25', '7', '20', '0', '7', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('26', '7', '21', '0', '8', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('27', '7', '22', '0', '8', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('28', '8', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('29', '8', '23', '0', '1', '2', null, null, null, null, 'left', '2', 'Y', 'Y', null), ('30', '8', '24', '0', '2', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('31', '8', '25', '0', '2', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('32', '8', '26', '0', '3', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('33', '9', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('34', '9', '27', '0', '1', '2', null, null, null, null, 'left', '2', 'Y', 'Y', null), ('35', '9', '28', '0', '2', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('36', '9', '29', '0', '2', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('37', '10', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('38', '10', '30', '0', '1', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('39', '10', '31', '0', '2', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('40', '11', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('41', '11', '4', '0', '1', '2', null, null, null, null, 'left', '2', 'Y', 'Y', null), ('42', '11', '32', '0', '2', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('43', '12', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('44', '12', '33', '0', '1', '2', null, null, null, null, 'left', '2', 'Y', 'Y', null), ('45', '13', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('46', '13', '34', '0', '1', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('47', '13', '35', '0', '2', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('48', '13', '36', '0', '2', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('49', '13', '37', '0', '3', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('50', '13', '38', '0', '3', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('51', '13', '39', '0', '4', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('52', '13', '40', '0', '4', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('53', '14', '3', '0', '1', '1', null, null, null, null, 'left', '0', 'Y', 'Y', null), ('54', '14', '41', '0', '1', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('55', '14', '44', '0', '2', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('56', '7', '5', '0', '9', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('57', '9', '5', '0', '3', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('58', '10', '5', '0', '2', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('59', '12', '5', '0', '2', '1', null, null, null, null, 'left', '0', 'N', 'Y', null), ('60', '13', '5', '0', '4', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('61', '14', '5', '0', '2', '2', null, null, null, null, 'left', '0', 'N', 'Y', null), ('62', '15', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('63', '15', '4', '0', '1', '2', null, null, null, null, 'left', '2', 'Y', 'Y', null), ('64', '16', '3', '0', '1', '1', null, null, null, null, 'left', '1', 'Y', 'Y', null), ('65', '16', '24', '0', '1', '2', null, null, null, null, 'left', '0', 'Y', 'Y', null), ('66', '7', '0', '5', '20', '1', null, null, null, null, 'left', null, 'N', 'Y', null), ('67', '7', '0', '7', '20', '2', null, null, null, null, 'left', null, 'N', 'Y', null), ('68', '7', '0', '8', '21', '1', null, null, null, null, 'left', null, 'N', 'Y', null), ('69', '7', '0', '13', '21', '2', null, null, null, null, 'left', null, 'N', 'Y', null), ('70', '7', '0', '9', '22', '1', null, null, null, null, 'left', null, 'N', 'Y', null), ('71', '12', '0', '10', '20', '1', null, null, null, null, 'left', null, 'N', 'Y', null), ('72', '7', '0', '11', '22', '2', null, null, null, null, 'left', null, 'N', 'Y', null), ('73', '13', '0', '12', '20', '1', null, null, null, null, 'left', null, 'N', 'Y', null), ('74', '7', '0', '6', '23', '1', null, null, null, null, 'left', null, 'N', 'Y', null), ('75', '7', '0', '14', '23', '2', null, null, null, null, 'left', null, 'N', 'Y', null);
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `metadb_lookups`
-- ----------------------------
BEGIN;
INSERT INTO `metadb_lookups` VALUES ('1', 'yes_no', 'R', '1');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `metadb_lookups_values`
-- ----------------------------
BEGIN;
INSERT INTO `metadb_lookups_values` VALUES ('1', '1', '1', 'Y', 'Y'), ('2', '1', '2', 'N', 'N');
COMMIT;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `metadb_relations`
-- ----------------------------
BEGIN;
INSERT INTO `metadb_relations` VALUES ('2', 'itg_disease-itg_synonym', 'Disease Synonym', 'relation between disease and synonym entities', '3', '5', 'T', 'itgDiseaseSynonym', 'Y'), ('3', 'itg_disease-itg_mdra', 'Disease MedDRA', 'Relation between disease and mdra entities', '3', '4', 'T', 'itgDiseaseMdra', 'Y'), ('4', 'itg_disease-itg_disease', 'Disease', '', '3', '3', 'M', 'itgDiseaseDisease', 'Y'), ('5', 'itg_drug-itg_phase', 'Phase', 'relation between drug and highest dev. phase', '7', '8', 'T', 'itgDrugHighPhase', 'Y'), ('6', 'itg_drug-itg_cas_number', 'CAS Number', null, '7', '9', 'T', 'itgDrugCasNum', 'Y'), ('7', 'itg_drug-itg_inchi', 'Inchi', null, '7', '10', 'T', 'itgDrugInchi', 'Y'), ('8', 'itg_drug-itg_chemname', 'Chemical name', null, '7', '15', 'T', 'itgDrugChemName', 'Y'), ('9', 'itg_drug-itg_acc_number', 'Drug', null, '7', '12', 'T', 'itgDrugAccNum', 'Y'), ('10', 'itg_acc_number-itg_database', 'Database', null, '12', '11', 'T', 'itgAccNumDatabase', 'Y'), ('11', 'itg_drug-itg_drugmilestone', 'Drug', null, '7', '13', 'T', 'itgMilestoneDrugDrug', 'Y'), ('12', 'itg_drugmilestone-itg_milestone', 'Milestone', null, '13', '16', 'T', 'itgDrugMilestoneMilestone', 'Y'), ('13', 'itg_drug-itg_dev_status', 'Dev. Status', null, '7', '14', 'T', 'itgDrugDevStatus', 'Y');
COMMIT;

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
