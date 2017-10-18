/*
 Navicat MySQL Data Transfer

 Source Server         : Local Host Root
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost:3306
 Source Schema         : itaps

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 18/10/2017 08:24:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `brewery_name` varchar(128) CHARACTER SET latin1 NOT NULL,
  `first_name` varchar(128) CHARACTER SET latin1 NOT NULL,
  `last_name` varchar(128) CHARACTER SET latin1 NOT NULL,
  `username` varchar(128) CHARACTER SET latin1 NOT NULL,
  `password` varchar(128) CHARACTER SET latin1 NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `tap_amount` int(2) NOT NULL,
  `volume_type` varchar(10) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `volume_type_abbrev` varchar(5) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of admin
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES (1, 'Your Brewery', 'Joe', 'Smith', 'joe', 'joe', 'joe@mac.com', 12, 'gallons', 'gal.');
COMMIT;

-- ----------------------------
-- Table structure for beers
-- ----------------------------
DROP TABLE IF EXISTS `beers`;
CREATE TABLE `beers` (
  `beer_id` int(3) NOT NULL AUTO_INCREMENT,
  `beer_name` tinytext CHARACTER SET utf8,
  `style_number_fk` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `og` decimal(4,3) DEFAULT NULL,
  `fg` decimal(4,3) DEFAULT NULL,
  `ibu` decimal(4,2) DEFAULT NULL,
  `srm_decimal` decimal(4,2) DEFAULT NULL,
  `srm_value_fk` int(2) DEFAULT NULL,
  `note` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `nonalchoholic` binary(1) DEFAULT NULL,
  PRIMARY KEY (`beer_id`),
  KEY `srm_value_fk` (`srm_value_fk`),
  KEY `style_number_fk` (`style_number_fk`),
  CONSTRAINT `srm_value_fk` FOREIGN KEY (`srm_value_fk`) REFERENCES `srm` (`srm_value`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of beers
-- ----------------------------
BEGIN;
INSERT INTO `beers` VALUES (1, 'Blood Orange Hefeweizen', '10A', 1.058, 1.012, 44.88, 7.58, 8, 'Made with one pound of blood oranges & love. Juicy', NULL);
INSERT INTO `beers` VALUES (2, 'St Wilfrid\'s ESB', '11C', 1.062, 1.018, 38.47, 8.60, 9, 'jahfjlhaevfjhvber', NULL);
INSERT INTO `beers` VALUES (3, 'Landbridge Imperial Pale Ale', '18B', 1.101, 1.018, 44.16, 6.54, 7, 'A mistake turned into a royal success.', NULL);
INSERT INTO `beers` VALUES (4, 'Jalapeño Kölsch', '05B', 1.052, 1.010, 30.00, 3.77, 4, 'Fresh Jalapeño aroma , little to no pepper bite, crisp, malty.', NULL);
INSERT INTO `beers` VALUES (5, 'El Azacca', '18B', 1.051, 1.011, 40.18, 6.81, 7, 'Tropical and Fruity. Pineapple', NULL);
INSERT INTO `beers` VALUES (17, 'St Mungo\'s 80/-', '14C', 1.053, 1.017, 17.35, 14.05, 14, '', NULL);
INSERT INTO `beers` VALUES (20, 'Red Star Pilsner', '03B', 1.049, 1.013, 38.08, 3.56, 4, '', NULL);
INSERT INTO `beers` VALUES (21, 'Ginger Ale', '00A', 1.000, 1.000, 0.00, 3.00, 3, '', 0x31);
INSERT INTO `beers` VALUES (22, 'Test 2', '16C', 1.061, 1.011, 12.89, 40.00, 40, '', NULL);
COMMIT;

-- ----------------------------
-- Table structure for bjcp_styles
-- ----------------------------
DROP TABLE IF EXISTS `bjcp_styles`;
CREATE TABLE `bjcp_styles` (
  `style_number` varchar(255) CHARACTER SET latin1 NOT NULL,
  `bjcp_category` varchar(255) CHARACTER SET latin1 NOT NULL,
  `style_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `style_family` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`style_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of bjcp_styles
-- ----------------------------
BEGIN;
INSERT INTO `bjcp_styles` VALUES ('00A', 'Non-beer', 'Soft Drink', 'None');
INSERT INTO `bjcp_styles` VALUES ('00B', 'Non-beer', 'Cider', 'None');
INSERT INTO `bjcp_styles` VALUES ('01A', 'Standard American Beer', 'American Light Lager', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('01B', 'Standard American Beer', 'American Lager', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('01C', 'Standard American Beer', 'Cream Ale', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('01D', 'Standard American Beer', 'American Wheat Beer', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('02A', 'International Lager', 'International Pale Lager', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('02B', 'International Lager', 'International Amber Lager', 'Amber Lager');
INSERT INTO `bjcp_styles` VALUES ('02C', 'International Lager', 'International Dark Lager', 'Dark Lager');
INSERT INTO `bjcp_styles` VALUES ('03A', 'Czech Lager', 'Czech Pale Lager', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('03B', 'Czech Lager', 'Czech Premium Pale Lager', 'Pilsner');
INSERT INTO `bjcp_styles` VALUES ('03C', 'Czech Lager', 'Czech Amber Lager', 'Amber Lager');
INSERT INTO `bjcp_styles` VALUES ('03D', 'Czech Lager', 'Czech Dark Lager', 'Dark Lager');
INSERT INTO `bjcp_styles` VALUES ('04A', 'Pale Malty European Lager', 'Munich Helles', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('04B', 'Pale Malty European Lager', 'Festbier', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('04C', 'Pale Malty European Lager', 'Helles Bock', 'Bock');
INSERT INTO `bjcp_styles` VALUES ('05A', 'Pale Bitter European beer', 'German Leichtbier', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('05B', 'Pale Bitter European beer', 'Kölsch', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('05C', 'Pale Bitter European beer', 'German Helles Exportbier', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('05D', 'Pale Bitter European beer', 'German Pils', 'Pilsner');
INSERT INTO `bjcp_styles` VALUES ('06A', 'Amber Malty European Lager', 'Märzen', 'Amber Lager');
INSERT INTO `bjcp_styles` VALUES ('06B', 'Amber Malty European Lager', 'Rauchbier', 'Amber Lager');
INSERT INTO `bjcp_styles` VALUES ('06C', 'Amber Malty European Lager', 'Dunkles Bock', 'Bock');
INSERT INTO `bjcp_styles` VALUES ('07A', 'Amber Bitter European Beer', 'Vienna Lager', 'Amber Lager');
INSERT INTO `bjcp_styles` VALUES ('07B', 'Amber Bitter European Beer', 'Altbier', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('07C', 'Amber Bitter European Beer', 'Pale Kellerbier', 'Pale Lager');
INSERT INTO `bjcp_styles` VALUES ('07D', 'Amber Bitter European Beer', 'Amber Kellerbier', 'Amber Lager');
INSERT INTO `bjcp_styles` VALUES ('08A', 'Dark European Lager', 'Munich Dunkel', 'Dark Lager');
INSERT INTO `bjcp_styles` VALUES ('08B', 'Dark European Lager', 'Schwarzbier', 'Dark Lager');
INSERT INTO `bjcp_styles` VALUES ('09A', 'Strong European Beer', 'Doppelbock', 'Bock');
INSERT INTO `bjcp_styles` VALUES ('09B', 'Strong European Beer', 'Eisbock', 'Bock');
INSERT INTO `bjcp_styles` VALUES ('09C', 'Strong European Beer', 'Baltic Porter', 'Porter');
INSERT INTO `bjcp_styles` VALUES ('10A', 'German Wheat Beer', 'Weissbier', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('10B', 'German Wheat Beer', 'Dunkles Weissbier', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('10C', 'German Wheat Beer', 'Weizenbock', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('11A', 'British Bitter', 'Ordinary Bitter', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('11B', 'British Bitter', 'Best Bitter', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('11C', 'British Bitter', 'Strong Bitter', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('12A', 'Pale Commonwealth Beer', 'British Golden Ale', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('12B', 'Pale Commonwealth Beer', 'Australian Sparkling Ale', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('12C', 'Pale Commonwealth Beer', 'English IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('13A', 'Brown British Beer', 'Dark Mild', 'Brown Ale');
INSERT INTO `bjcp_styles` VALUES ('13B', 'Brown British Beer', 'British Brown Ale', 'Brown Ale');
INSERT INTO `bjcp_styles` VALUES ('13C', 'Brown British Beer', 'English Porter', 'Porter');
INSERT INTO `bjcp_styles` VALUES ('14A', 'Scottish Ale', 'Scottish Light', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('14B', 'Scottish Ale', 'Scottish Heavy', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('14C', 'Scottish Ale', 'Scottish Export', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('15A', 'Irish Beer', 'Irish Red Ale', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('15B', 'Irish Beer', 'Irish Stout', 'Stout');
INSERT INTO `bjcp_styles` VALUES ('15C', 'Irish Beer', 'Irish Extra Stout', 'Stout');
INSERT INTO `bjcp_styles` VALUES ('16A', 'Dark British Beer', 'Sweet Stout', 'Stout');
INSERT INTO `bjcp_styles` VALUES ('16B', 'Dark British Beer', 'Oatmeal Stout', 'Stout');
INSERT INTO `bjcp_styles` VALUES ('16C', 'Dark British Beer', 'Tropical Stout', 'Stout');
INSERT INTO `bjcp_styles` VALUES ('16D', 'Dark British Beer', 'Foreign Extra Stout', 'Stout');
INSERT INTO `bjcp_styles` VALUES ('17A', 'Strong British Ale', 'British Strong Ale', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('17B', 'Strong British Ale', 'Old Ale', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('17C', 'Strong British Ale', 'Wee Heavy', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('17D', 'Strong British Ale', 'English Barleywine', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('18A', 'Pale American Ale', 'Blonde Ale', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('18B', 'Pale American Ale', 'American Pale Ale', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('19A', 'Amber and Brown American Beer', 'American Amber Ale', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('19B', 'Amber and Brown American Beer', 'California Common ', 'Amber Lager');
INSERT INTO `bjcp_styles` VALUES ('19C', 'Amber and Brown American Beer', 'American Brown Ale', 'Brown Ale');
INSERT INTO `bjcp_styles` VALUES ('20A', 'American Porter and Stout', 'American Porter', 'Porter');
INSERT INTO `bjcp_styles` VALUES ('20B', 'American Porter and Stout', 'American Stout', 'Stout');
INSERT INTO `bjcp_styles` VALUES ('20C', 'American Porter and Stout', 'Imperial Stout', 'Stout');
INSERT INTO `bjcp_styles` VALUES ('21A', 'IPA', 'American IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('21B', 'IPA', 'Specialty IPA - Belgian IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('21C', 'IPA', 'Specialty IPA - Black IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('21D', 'IPA', 'Specialty IPA - Brown IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('21E', 'IPA', 'Specialty IPA - Red IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('21F', 'IPA', 'Specialty IPA - Rye IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('21G', 'IPA', 'Specialty IPA - White IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('22A', 'Strong American Ale', 'Double IPA', 'IPA');
INSERT INTO `bjcp_styles` VALUES ('22B', 'Strong American Ale', 'American Strong Ale', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('22C', 'Strong American Ale', 'American Barleywine', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('22D', 'Strong American Ale', 'Wheatwine', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('23A', 'European Sour Ale', 'Berliner Weisse', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('23B', 'European Sour Ale', 'Flanders Red Ale', 'Sour Ale');
INSERT INTO `bjcp_styles` VALUES ('23C', 'European Sour Ale', 'Oud Bruin', 'Sour Ale');
INSERT INTO `bjcp_styles` VALUES ('23D', 'European Sour Ale', 'Lambic', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('23E', 'European Sour Ale', 'Gueuze ', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('23F', 'European Sour Ale', 'Fruit Lambic', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('24A', 'Belgian Ale', 'Witbier', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('24B', 'Belgian Ale', 'Belgian Pale Ale', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('24C', 'Belgian Ale', 'Bière de Garde', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('25A', 'Strong Belgian Ale', 'Belgian Blond Ale', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('25B', 'Strong Belgian Ale', 'Saison', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('25C', 'Strong Belgian Ale', 'Belgian Golden Strong Ale', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('26A', 'Trappist Ale', 'Trappist Single', 'Pale Ale');
INSERT INTO `bjcp_styles` VALUES ('26B', 'Trappist Ale', 'Belgian Dubbel', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('26C', 'Trappist Ale', 'Belgian Tripel', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('26D', 'Trappist Ale', 'Belgian Dark Strong Ale', 'Strong Ale');
INSERT INTO `bjcp_styles` VALUES ('27A', 'Historical Beer', 'Gose', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('27B', 'Historical Beer', 'Kentucky Common', 'Amber Ale');
INSERT INTO `bjcp_styles` VALUES ('27C', 'Historical Beer', 'Lichtenhainer', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('27D', 'Historical Beer', 'London Brown Ale', 'Brown Ale');
INSERT INTO `bjcp_styles` VALUES ('27E', 'Historical Beer', 'Piwo Grodziskie', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('27F', 'Historical Beer', 'Pre-Prohibition Lager', 'Pilsner');
INSERT INTO `bjcp_styles` VALUES ('27G', 'Historical Beer', 'Pre-Prohibition Porter', 'Porter');
INSERT INTO `bjcp_styles` VALUES ('27H', 'Historical Beer', 'Roggenbier', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('27I', 'Historical Beer', 'Sahti', 'Wheat Beer');
INSERT INTO `bjcp_styles` VALUES ('28A', 'American Wild Ale', 'Brett Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('28B', 'American Wild Ale', 'Mixed-Fermentation Sour Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('28C', 'American Wild Ale', 'Wild Specialty Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('29A', 'Fruit Beer', 'Fruit Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('29B', 'Fruit Beer', 'Fruit and Spice Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('29C', 'Fruit Beer', 'Specialty Fruit Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('30A', 'Spiced Beer', 'Spice, Herb, or Vegetable Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('30B', 'Spiced Beer', 'Autumn Seasonal Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('30C', 'Spiced Beer', 'Winter Seasonal Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('31A', 'Alternative Fermentables Beer', 'Alternative Grain Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('31B', 'Alternative Fermentables Beer', 'Alternative Sugar Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('32A', 'Smoked Beer', 'Classic Style Smoked Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('32B', 'Smoked Beer', 'Specialty Smoked Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('33A', 'Wood Beer', 'Wood-Aged Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('33B', 'Wood Beer', 'Specialty Wood-Aged Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('34A', 'Specialty Beer', 'Clone Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('34B', 'Specialty Beer', 'Mixed-Style Beer', 'Specialty Beer');
INSERT INTO `bjcp_styles` VALUES ('34C', 'Specialty Beer', 'Experimental Beer', 'Specialty Beer');
COMMIT;

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `config_value` longtext CHARACTER SET latin1 NOT NULL,
  `display_name` varchar(65) CHARACTER SET latin1 NOT NULL,
  `show_on_panel` tinyint(2) NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of config
-- ----------------------------
BEGIN;
INSERT INTO `config` VALUES (1, 'show_tap_num_col', '1', 'Tap Column', 1);
INSERT INTO `config` VALUES (2, 'show_srm_col', '1', 'SRM Column', 1);
INSERT INTO `config` VALUES (3, 'show_ibu_col', '1', 'IBU Column', 1);
INSERT INTO `config` VALUES (4, 'show_abv_col', '1', 'ABV Column', 1);
INSERT INTO `config` VALUES (5, 'show_abv_img', '1', 'ABV Images', 1);
INSERT INTO `config` VALUES (6, 'show_keg_col', '0', 'Keg Column', 1);
INSERT INTO `config` VALUES (7, 'use_high_res', '0', '4k Monitor Support', 1);
INSERT INTO `config` VALUES (8, 'logo_url', 'img/logo.png', 'Logo Url', 0);
INSERT INTO `config` VALUES (9, 'admin_logo_url', 'admin/img/logo.png', 'Admin Logo Url', 0);
INSERT INTO `config` VALUES (10, 'header_text', 'Now Pouring', 'Header Text', 1);
INSERT INTO `config` VALUES (11, 'number_of_taps', '6', 'Number of Taps', 0);
INSERT INTO `config` VALUES (12, 'version', '1.0.0-beta', 'Version', 0);
INSERT INTO `config` VALUES (13, 'header_text_trunc_len', '20', 'Header Text Truncate Length', 0);
INSERT INTO `config` VALUES (14, 'use_flow_meter', '0', 'Use Flow Monitoring', 1);
INSERT INTO `config` VALUES (15, 'current_theme', '1', 'Current Theme', 1);
COMMIT;

-- ----------------------------
-- Table structure for keg_status
-- ----------------------------
DROP TABLE IF EXISTS `keg_status`;
CREATE TABLE `keg_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`status_id`),
  KEY `status` (`status_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of keg_status
-- ----------------------------
BEGIN;
INSERT INTO `keg_status` VALUES (5, 'Conditioning');
INSERT INTO `keg_status` VALUES (2, 'Empty—Clean');
INSERT INTO `keg_status` VALUES (3, 'Empty—Dirty');
INSERT INTO `keg_status` VALUES (6, 'Maintenance');
INSERT INTO `keg_status` VALUES (4, 'On Deck');
INSERT INTO `keg_status` VALUES (1, 'Tapped');
COMMIT;

-- ----------------------------
-- Table structure for keg_types
-- ----------------------------
DROP TABLE IF EXISTS `keg_types`;
CREATE TABLE `keg_types` (
  `keg_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` text CHARACTER SET latin1 NOT NULL,
  `max_amount` decimal(6,2) NOT NULL,
  PRIMARY KEY (`keg_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of keg_types
-- ----------------------------
BEGIN;
INSERT INTO `keg_types` VALUES (1, 'Ball Lock (5 gal)', 5.00);
INSERT INTO `keg_types` VALUES (2, 'Ball Lock (2.5 gal)', 2.50);
INSERT INTO `keg_types` VALUES (3, 'Ball Lock (3 gal)', 3.00);
INSERT INTO `keg_types` VALUES (4, 'Ball Lock (10 gal)', 10.00);
INSERT INTO `keg_types` VALUES (5, 'Pin Lock (5 gal)', 5.00);
INSERT INTO `keg_types` VALUES (6, 'Sanke (1/6 bbl)', 5.16);
INSERT INTO `keg_types` VALUES (7, 'Sanke (1/4 bbl)', 7.75);
INSERT INTO `keg_types` VALUES (8, 'Sanke (slim 1/4 bbl)', 7.75);
INSERT INTO `keg_types` VALUES (9, 'Sanke (1/2 bbl)', 15.50);
INSERT INTO `keg_types` VALUES (10, 'Sanke (Euro)', 13.20);
INSERT INTO `keg_types` VALUES (11, 'Cask (pin)', 10.81);
INSERT INTO `keg_types` VALUES (12, 'Cask (firkin)', 10.81);
INSERT INTO `keg_types` VALUES (13, 'Cask (kilderkin)', 21.62);
INSERT INTO `keg_types` VALUES (14, 'Cask (barrel)', 43.23);
INSERT INTO `keg_types` VALUES (15, 'Cask (hogshead)', 64.85);
COMMIT;

-- ----------------------------
-- Table structure for kegs
-- ----------------------------
DROP TABLE IF EXISTS `kegs`;
CREATE TABLE `kegs` (
  `keg_id` int(2) NOT NULL,
  `keg_type_id_fk` int(3) NOT NULL,
  `status_id_fk` int(1) NOT NULL,
  `beer_id_fk` int(3) DEFAULT NULL,
  `make` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `model` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `serial` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `note` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `fill` int(3) DEFAULT NULL,
  PRIMARY KEY (`keg_id`),
  KEY `status_id_fk` (`status_id_fk`),
  KEY `beer_id_fk` (`beer_id_fk`),
  KEY `type_id_fk` (`keg_type_id_fk`),
  CONSTRAINT `beer_id_fk` FOREIGN KEY (`beer_id_fk`) REFERENCES `beers` (`beer_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `keg_type_id_fk` FOREIGN KEY (`keg_type_id_fk`) REFERENCES `keg_types` (`keg_type_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `status_id_fk` FOREIGN KEY (`status_id_fk`) REFERENCES `keg_status` (`status_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of kegs
-- ----------------------------
BEGIN;
INSERT INTO `kegs` VALUES (1, 1, 1, 17, 'jjkshdkvuhf', 'b,j,bfdjhsbfdjhsb', '8', 'Shiny not dull', 0);
INSERT INTO `kegs` VALUES (2, 1, 1, 3, '', '', '5', 'Dullish black', 100);
INSERT INTO `kegs` VALUES (3, 1, 1, 4, 'Firestone', '', '345367357', 'Skinny', 0);
INSERT INTO `kegs` VALUES (4, 1, 1, 20, '', '', 'testserial5', 'test note', 100);
INSERT INTO `kegs` VALUES (5, 1, 1, 21, '', '', '4764583', 'New rings', NULL);
INSERT INTO `kegs` VALUES (9, 1, 1, 1, 'retagged', 'sdfgsdf', 'dsfgsdfg', 'sfdgfdg', NULL);
COMMIT;

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `memberID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `active` varchar(255) CHARACTER SET latin1 NOT NULL,
  `resetToken` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `resetComplete` varchar(3) CHARACTER SET latin1 DEFAULT 'No',
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of members
-- ----------------------------
BEGIN;
INSERT INTO `members` VALUES (2, 'iainwb', '$2y$10$.mizwDh9LGj.CP4LYN/mnu.JIljYgCpnN2/nZ4Zq0KZjU5SgKjXM.', 'iainwb@mac.com', 'Yes', NULL, 'No');
COMMIT;

-- ----------------------------
-- Table structure for srm
-- ----------------------------
DROP TABLE IF EXISTS `srm`;
CREATE TABLE `srm` (
  `srm_value` int(2) NOT NULL,
  `hex_color` varchar(7) CHARACTER SET latin1 DEFAULT NULL,
  `color_name` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`srm_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of srm
-- ----------------------------
BEGIN;
INSERT INTO `srm` VALUES (1, '#fefe45', 'Pale Straw');
INSERT INTO `srm` VALUES (2, '#fefe45', 'Pale Straw');
INSERT INTO `srm` VALUES (3, '#ffe83d', 'Straw');
INSERT INTO `srm` VALUES (4, '#fdd749', 'Pale Gold');
INSERT INTO `srm` VALUES (5, '#fdd749', 'Pale Gold');
INSERT INTO `srm` VALUES (6, '#ffa846', 'Deep Gold');
INSERT INTO `srm` VALUES (7, '#ffa846', 'Deep Gold');
INSERT INTO `srm` VALUES (8, '#ffa846', 'Deep Gold');
INSERT INTO `srm` VALUES (9, '#f39f43', 'Pale Amber');
INSERT INTO `srm` VALUES (10, '#f39f43', 'Pale Amber');
INSERT INTO `srm` VALUES (11, '#f39f43', 'Pale Amber');
INSERT INTO `srm` VALUES (12, '#d67f58', 'Medium Amber');
INSERT INTO `srm` VALUES (13, '#d67f58', 'Medium Amber');
INSERT INTO `srm` VALUES (14, '#d67f58', 'Medium Amber');
INSERT INTO `srm` VALUES (15, '#935239', 'Deep Amber');
INSERT INTO `srm` VALUES (16, '#935239', 'Deep Amber');
INSERT INTO `srm` VALUES (17, '#935239', 'Deep Amber');
INSERT INTO `srm` VALUES (18, '#7f4540', 'Amber-Brown');
INSERT INTO `srm` VALUES (19, '#7f4540', 'Amber-Brown');
INSERT INTO `srm` VALUES (20, '#5b342f', 'Brown');
INSERT INTO `srm` VALUES (21, '#5b342f', 'Brown');
INSERT INTO `srm` VALUES (22, '#5b342f', 'Brown');
INSERT INTO `srm` VALUES (23, '#5b342f', 'Brown');
INSERT INTO `srm` VALUES (24, '#4b3a2a', 'Ruby Brown');
INSERT INTO `srm` VALUES (25, '#4b3a2a', 'Ruby Brown');
INSERT INTO `srm` VALUES (26, '#4b3a2a', 'Ruby Brown');
INSERT INTO `srm` VALUES (27, '#4b3a2a', 'Ruby Brown');
INSERT INTO `srm` VALUES (28, '#4b3a2a', 'Ruby Brown');
INSERT INTO `srm` VALUES (29, '#4b3a2a', 'Ruby Brown');
INSERT INTO `srm` VALUES (30, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (31, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (32, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (33, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (34, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (35, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (36, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (37, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (38, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (39, '#382f2d', 'Deep Brown');
INSERT INTO `srm` VALUES (40, '#31302b', 'Black');
COMMIT;

-- ----------------------------
-- Table structure for tap_status
-- ----------------------------
DROP TABLE IF EXISTS `tap_status`;
CREATE TABLE `tap_status` (
  `tap_id` int(11) NOT NULL,
  `keg_id_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`tap_id`),
  KEY `keg` (`keg_id_fk`),
  CONSTRAINT `keg_id_fk` FOREIGN KEY (`keg_id_fk`) REFERENCES `kegs` (`keg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tap_status
-- ----------------------------
BEGIN;
INSERT INTO `tap_status` VALUES (1, 1);
INSERT INTO `tap_status` VALUES (2, 2);
INSERT INTO `tap_status` VALUES (3, 3);
INSERT INTO `tap_status` VALUES (4, 4);
INSERT INTO `tap_status` VALUES (5, 5);
INSERT INTO `tap_status` VALUES (6, 9);
COMMIT;

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `diacritics` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of test
-- ----------------------------
BEGIN;
INSERT INTO `test` VALUES (1, 'gøse');
INSERT INTO `test` VALUES (2, 'b');
INSERT INTO `test` VALUES (3, 'c');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) CHARACTER SET utf8 NOT NULL,
  `password` varchar(65) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(65) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(65) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(65) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
