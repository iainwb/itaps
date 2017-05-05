/*
 Navicat MySQL Data Transfer

 Source Server         : Local Host Root
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost
 Source Database       : itaps

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : utf-8

 Date: 05/05/2017 11:19:27 AM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `2015-bjcp-styles`
-- ----------------------------
DROP TABLE IF EXISTS `2015-bjcp-styles`;
CREATE TABLE `2015-bjcp-styles` (
  `styleNumber` varchar(255) NOT NULL,
  `bjcpCategories` varchar(255) NOT NULL,
  `styleName` varchar(255) NOT NULL,
  `styleFamily` varchar(255) NOT NULL,
  PRIMARY KEY (`styleNumber`),
  KEY `#` (`styleNumber`),
  KEY `Style` (`styleName`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `2015-bjcp-styles`
-- ----------------------------
BEGIN;
INSERT INTO `2015-bjcp-styles` VALUES ('01A', 'Standard American Beer', 'American Light Lager', 'Pale Lager'), ('01B', 'Standard American Beer', 'American Lager', 'Pale Lager'), ('01C', 'Standard American Beer', 'Cream Ale', 'Pale Ale'), ('01D', 'Standard American Beer', 'American Wheat Beer', 'Wheat Beer'), ('02A', 'International Lager', 'International Pale Lager', 'Pale Lager'), ('02B', 'International Lager', 'International Amber Lager', 'Amber Lager'), ('02C', 'International Lager', 'International Dark Lager', 'Dark Lager'), ('03A', 'Czech Lager', 'Czech Pale Lager', 'Pale Lager'), ('03B', 'Czech Lager', 'Czech Premium Pale Lager', 'Pilsner'), ('03C', 'Czech Lager', 'Czech Amber Lager', 'Amber Lager'), ('03D', 'Czech Lager', 'Czech Dark Lager', 'Dark Lager'), ('04A', 'Pale Malty European Lager', 'Munich Helles', 'Pale Lager'), ('04B', 'Pale Malty European Lager', 'Festbier', 'Pale Lager'), ('04C', 'Pale Malty European Lager', 'Helles Bock', 'Bock'), ('05A', 'Pale Bitter European beer', 'German Leichtbier', 'Pale Lager'), ('05B', 'Pale Bitter European beer', 'Kölsch', 'Pale Ale'), ('05C', 'Pale Bitter European beer', 'German Helles Exportbier', 'Pale Lager'), ('05D', 'Pale Bitter European beer', 'German Pils', 'Pilsner'), ('06A', 'Amber Malty European Lager', 'Märzen', 'Amber Lager'), ('06B', 'Amber Malty European Lager', 'Rauchbier', 'Amber Lager'), ('06C', 'Amber Malty European Lager', 'Dunkles Bock', 'Bock'), ('07A', 'Amber Bitter European Beer', 'Vienna Lager', 'Amber Lager'), ('07B', 'Amber Bitter European Beer', 'Altbier', 'Amber Ale'), ('07C', 'Amber Bitter European Beer', 'Pale Kellerbier', 'Pale Lager'), ('07D', 'Amber Bitter European Beer', 'Amber Kellerbier', 'Amber Lager'), ('08A', 'Dark European Lager', 'Munich Dunkel', 'Dark Lager'), ('08B', 'Dark European Lager', 'Schwarzbier', 'Dark Lager'), ('09A', 'Strong European Beer', 'Doppelbock', 'Bock'), ('09B', 'Strong European Beer', 'Eisbock', 'Bock'), ('09C', 'Strong European Beer', 'Baltic Porter', 'Porter'), ('10A', 'German Wheat Beer', 'Weissbier', 'Wheat Beer'), ('10B', 'German Wheat Beer', 'Dunkles Weissbier', 'Wheat Beer'), ('10C', 'German Wheat Beer', 'Weizenbock', 'Wheat Beer'), ('11A', 'British Bitter', 'Ordinary Bitter', 'Amber Ale'), ('11B', 'British Bitter', 'Best Bitter', 'Amber Ale'), ('11C', 'British Bitter', 'Strong Bitter', 'Amber Ale'), ('12A', 'Pale Commonwealth Beer', 'British Golden Ale', 'Pale Ale'), ('12B', 'Pale Commonwealth Beer', 'Australian Sparkling Ale', 'Pale Ale'), ('12C', 'Pale Commonwealth Beer', 'English IPA', 'IPA'), ('13A', 'Brown British Beer', 'Dark Mild', 'Brown Ale'), ('13B', 'Brown British Beer', 'British Brown Ale', 'Brown Ale'), ('13C', 'Brown British Beer', 'English Porter', 'Porter'), ('14A', 'Scottish Ale', 'Scottish Light', 'Amber Ale'), ('14B', 'Scottish Ale', 'Scottish Heavy', 'Amber Ale'), ('14C', 'Scottish Ale', 'Scottish Export', 'Amber Ale'), ('15A', 'Irish Beer', 'Irish Red Ale', 'Amber Ale'), ('15B', 'Irish Beer', 'Irish Stout', 'Stout'), ('15C', 'Irish Beer', 'Irish Extra Stout', 'Stout'), ('16A', 'Dark British Beer', 'Sweet Stout', 'Stout'), ('16B', 'Dark British Beer', 'Oatmeal Stout', 'Stout'), ('16C', 'Dark British Beer', 'Tropical Stout', 'Stout'), ('16D', 'Dark British Beer', 'Foreign Extra Stout', 'Stout'), ('17A', 'Strong British Ale', 'British Strong Ale', 'Strong Ale'), ('17B', 'Strong British Ale', 'Old Ale', 'Strong Ale'), ('17C', 'Strong British Ale', 'Wee Heavy', 'Strong Ale'), ('17D', 'Strong British Ale', 'English Barleywine', 'Strong Ale'), ('18A', 'Pale American Ale', 'Blonde Ale', 'Pale Ale'), ('18B', 'Pale American Ale', 'American Pale Ale', 'Pale Ale'), ('19A', 'Amber and Brown American Beer', 'American Amber Ale', 'Amber Ale'), ('19B', 'Amber and Brown American Beer', 'California Common ', 'Amber Lager'), ('19C', 'Amber and Brown American Beer', 'American Brown Ale', 'Brown Ale'), ('20A', 'American Porter and Stout', 'American Porter', 'Porter'), ('20B', 'American Porter and Stout', 'American Stout', 'Stout'), ('20C', 'American Porter and Stout', 'Imperial Stout', 'Stout'), ('21A', 'IPA', 'American IPA', 'IPA'), ('21B', 'IPA', 'Specialty IPA - Belgian IPA', 'IPA'), ('21C', 'IPA', 'Specialty IPA - Black IPA', 'IPA'), ('21D', 'IPA', 'Specialty IPA - Brown IPA', 'IPA'), ('21E', 'IPA', 'Specialty IPA - Red IPA', 'IPA'), ('21F', 'IPA', 'Specialty IPA - Rye IPA', 'IPA'), ('21G', 'IPA', 'Specialty IPA - White IPA', 'IPA'), ('22A', 'Strong American Ale', 'Double IPA', 'IPA'), ('22B', 'Strong American Ale', 'American Strong Ale', 'Strong Ale'), ('22C', 'Strong American Ale', 'American Barleywine', 'Strong Ale'), ('22D', 'Strong American Ale', 'Wheatwine', 'Strong Ale'), ('23A', 'European Sour Ale', 'Berliner Weisse', 'Wheat Beer'), ('23B', 'European Sour Ale', 'Flanders Red Ale', 'Sour Ale'), ('23C', 'European Sour Ale', 'Oud Bruin', 'Sour Ale'), ('23D', 'European Sour Ale', 'Lambic', 'Wheat Beer'), ('23E', 'European Sour Ale', 'Gueuze ', 'Wheat Beer'), ('23F', 'European Sour Ale', 'Fruit Lambic', 'Wheat Beer'), ('24A', 'Belgian Ale', 'Witbier', 'Wheat Beer'), ('24B', 'Belgian Ale', 'Belgian Pale Ale', 'Pale Ale'), ('24C', 'Belgian Ale', 'Bière de Garde', 'Amber Ale'), ('25A', 'Strong Belgian Ale', 'Belgian Blond Ale', 'Pale Ale'), ('25B', 'Strong Belgian Ale', 'Saison', 'Pale Ale'), ('25C', 'Strong Belgian Ale', 'Belgian Golden Strong Ale', 'Strong Ale'), ('26A', 'Trappist Ale', 'Trappist Single', 'Pale Ale'), ('26B', 'Trappist Ale', 'Belgian Dubbel', 'Amber Ale'), ('26C', 'Trappist Ale', 'Belgian Tripel', 'Strong Ale'), ('26D', 'Trappist Ale', 'Belgian Dark Strong Ale', 'Strong Ale'), ('27A', 'Historical Beer', 'Gose', 'Wheat Beer'), ('27B', 'Historical Beer', 'Kentucky Common', 'Amber Ale'), ('27C', 'Historical Beer', 'Lichtenhainer', 'Wheat Beer'), ('27D', 'Historical Beer', 'London Brown Ale', 'Brown Ale'), ('27E', 'Historical Beer', 'Piwo Grodziskie', 'Wheat Beer'), ('27F', 'Historical Beer', 'Pre-Prohibition Lager', 'Pilsner'), ('27G', 'Historical Beer', 'Pre-Prohibition Porter', 'Porter'), ('27H', 'Historical Beer', 'Roggenbier', 'Wheat Beer'), ('27I', 'Historical Beer', 'Sahti', 'Wheat Beer'), ('28A', 'American Wild Ale', 'Brett Beer', 'Specialty Beer'), ('28B', 'American Wild Ale', 'Mixed-Fermentation Sour Beer', 'Specialty Beer'), ('28C', 'American Wild Ale', 'Wild Specialty Beer', 'Specialty Beer'), ('29A', 'Fruit Beer', 'Fruit Beer', 'Specialty Beer'), ('29B', 'Fruit Beer', 'Fruit and Spice Beer', 'Specialty Beer'), ('29C', 'Fruit Beer', 'Specialty Fruit Beer', 'Specialty Beer'), ('30A', 'Spiced Beer', 'Spice, Herb, or Vegetable Beer', 'Specialty Beer'), ('30B', 'Spiced Beer', 'Autumn Seasonal Beer', 'Specialty Beer'), ('30C', 'Spiced Beer', 'Winter Seasonal Beer', 'Specialty Beer'), ('31A', 'Alternative Fermentables Beer', 'Alternative Grain Beer', 'Specialty Beer'), ('31B', 'Alternative Fermentables Beer', 'Alternative Sugar Beer', 'Specialty Beer'), ('32A', 'Smoked Beer', 'Classic Style Smoked Beer', 'Specialty Beer'), ('32B', 'Smoked Beer', 'Specialty Smoked Beer', 'Specialty Beer'), ('33A', 'Wood Beer', 'Wood-Aged Beer', 'Specialty Beer'), ('33B', 'Wood Beer', 'Specialty Wood-Aged Beer', 'Specialty Beer'), ('34A', 'Specialty Beer', 'Clone Beer', 'Specialty Beer'), ('34B', 'Specialty Beer', 'Mixed-Style Beer', 'Specialty Beer'), ('34C', 'Specialty Beer', 'Experimental Beer', 'Specialty Beer');
COMMIT;

-- ----------------------------
--  Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `breweryName` varchar(128) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tapAmount` int(2) NOT NULL,
  `volumeType` varchar(10) NOT NULL DEFAULT '',
  `volumeTypeAbbrev` varchar(5) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `admin`
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES ('1', 'Your Brewery', 'Joe', 'Smith', 'joe', 'joe', 'joe@mac.com', '4', 'gallons', 'gal.');
COMMIT;

-- ----------------------------
--  Table structure for `beers`
-- ----------------------------
DROP TABLE IF EXISTS `beers`;
CREATE TABLE `beers` (
  `beer_id` int(3) NOT NULL AUTO_INCREMENT,
  `beerName` tinytext,
  `styleNumber_fk` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `og` decimal(4,3) DEFAULT NULL,
  `fg` decimal(4,3) DEFAULT NULL,
  `ibu` decimal(4,2) DEFAULT NULL,
  `srmDecimal` decimal(4,2) DEFAULT NULL,
  `srmValue_fk` int(2) DEFAULT NULL,
  `note` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`beer_id`),
  KEY `styleNumber_fk` (`styleNumber_fk`),
  KEY `srmValue_fk` (`srmValue_fk`),
  CONSTRAINT `srmValue_fk` FOREIGN KEY (`srmValue_fk`) REFERENCES `srm` (`srmValue`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `styleNumber_fk` FOREIGN KEY (`styleNumber_fk`) REFERENCES `2015-bjcp-styles` (`styleNumber`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `beers`
-- ----------------------------
BEGIN;
INSERT INTO `beers` VALUES ('1', 'Blood Orange Hefeweizen', '10A', '1.048', '1.012', '13.08', '3.59', '4', 'Made with one pound of blood oranges & love.'), ('2', 'St Wilfrid\'s ESB', '11C', '1.062', '1.018', '38.47', '8.60', '9', 'jahfjlhaevfjhvber'), ('3', 'Landbridge Imperial Pale Ale', '18B', '1.101', '1.018', '44.16', '6.54', '7', 'A mistake turned into a royal success.'), ('4', 'Jalapeño Kölsch', '05B', '1.052', '1.010', '30.00', '3.77', '4', 'Fresh Jalapeño aroma , little to no pepper bite, crisp, malty.'), ('7', 'El Azacca', '18B', '1.051', '1.011', '40.18', '6.81', '7', 'Tropical and Fruity. Pineapple');
COMMIT;

-- ----------------------------
--  Table structure for `keg-status`
-- ----------------------------
DROP TABLE IF EXISTS `keg-status`;
CREATE TABLE `keg-status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`status_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `keg-status`
-- ----------------------------
BEGIN;
INSERT INTO `keg-status` VALUES ('5', 'Conditioning'), ('2', 'Empty&#8212;Clean'), ('3', 'Empty&#8212;Dirty'), ('6', 'Maintenance'), ('4', 'On Deck'), ('1', 'Tapped');
COMMIT;

-- ----------------------------
--  Table structure for `kegs`
-- ----------------------------
DROP TABLE IF EXISTS `kegs`;
CREATE TABLE `kegs` (
  `keg_id` int(2) NOT NULL,
  `volume` decimal(3,1) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status_id_fk` int(1) NOT NULL,
  `serial` varchar(128) DEFAULT NULL,
  `mfg` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `fill` int(3) DEFAULT NULL,
  `beer_id_fk` int(3) DEFAULT NULL,
  PRIMARY KEY (`keg_id`),
  KEY `status_id_fk` (`status_id_fk`),
  KEY `beer_id_fk` (`beer_id_fk`),
  CONSTRAINT `beer_id_fk` FOREIGN KEY (`beer_id_fk`) REFERENCES `beers` (`beer_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `status_id_fk` FOREIGN KEY (`status_id_fk`) REFERENCES `keg-status` (`status_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `kegs`
-- ----------------------------
BEGIN;
INSERT INTO `kegs` VALUES ('1', '5.0', 'Firestone', '1', '8', 'AB', 'Shiny not', '0', '1'), ('2', '5.0', 'Corenelius', '1', '5', 'SABMC', 'Dullish black', '100', '4'), ('3', '5.0', 'Firestone', '1', '3', 'Pepsico', 'Skinny', '0', '3'), ('4', '5.0', 'Firestone', '6', 'testserial5', 'test mfg', 'test note', '100', null), ('5', '5.0', '', '1', '4764583', 'None', 'New rings', null, '2'), ('6', '5.0', 'Corney', '2', '72495876429', '45432', 'Slick', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `on-tap`
-- ----------------------------
DROP TABLE IF EXISTS `on-tap`;
CREATE TABLE `on-tap` (
  `tap_id` int(11) NOT NULL,
  `keg_id_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`tap_id`),
  KEY `keg` (`keg_id_fk`),
  CONSTRAINT `keg_id_fk` FOREIGN KEY (`keg_id_fk`) REFERENCES `kegs` (`keg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `on-tap`
-- ----------------------------
BEGIN;
INSERT INTO `on-tap` VALUES ('2', '1'), ('3', '2'), ('1', '3'), ('4', '5');
COMMIT;

-- ----------------------------
--  Table structure for `srm`
-- ----------------------------
DROP TABLE IF EXISTS `srm`;
CREATE TABLE `srm` (
  `srmValue` int(2) NOT NULL,
  `hexColor` varchar(7) DEFAULT NULL,
  `colorName` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`srmValue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `srm`
-- ----------------------------
BEGIN;
INSERT INTO `srm` VALUES ('1', '#fefe45', 'Pale Straw'), ('2', '#fefe45', 'Pale Straw'), ('3', '#ffe83d', 'Straw'), ('4', '#fdd749', 'Pale Gold'), ('5', '#fdd749', 'Pale Gold'), ('6', '#ffa846', 'Deep Gold'), ('7', '#ffa846', 'Deep Gold'), ('8', '#ffa846', 'Deep Gold'), ('9', '#f39f43', 'Pale Amber'), ('10', '#f39f43', 'Pale Amber'), ('11', '#f39f43', 'Pale Amber'), ('12', '#d67f58', 'Medium Amber'), ('13', '#d67f58', 'Medium Amber'), ('14', '#d67f58', 'Medium Amber'), ('15', '#935239', 'Deep Amber'), ('16', '#935239', 'Deep Amber'), ('17', '#935239', 'Deep Amber'), ('18', '#7f4540', 'Amber-Brown'), ('19', '#7f4540', 'Amber-Brown'), ('20', '#5b342f', 'Brown'), ('21', '#5b342f', 'Brown'), ('22', '#5b342f', 'Brown'), ('23', '#5b342f', 'Brown'), ('24', '#4b3a2a', 'Ruby Brown'), ('25', '#4b3a2a', 'Ruby Brown'), ('26', '#4b3a2a', 'Ruby Brown'), ('27', '#4b3a2a', 'Ruby Brown'), ('28', '#4b3a2a', 'Ruby Brown'), ('29', '#4b3a2a', 'Ruby Brown'), ('30', '#382f2d', 'Deep Brown'), ('31', '#382f2d', 'Deep Brown'), ('32', '#382f2d', 'Deep Brown'), ('33', '#382f2d', 'Deep Brown'), ('34', '#382f2d', 'Deep Brown'), ('35', '#382f2d', 'Deep Brown'), ('36', '#382f2d', 'Deep Brown'), ('37', '#382f2d', 'Deep Brown'), ('38', '#382f2d', 'Deep Brown'), ('39', '#382f2d', 'Deep Brown'), ('40', '#31302b', 'Black');
COMMIT;

-- ----------------------------
--  Table structure for `test`
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `diacritics` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `test`
-- ----------------------------
BEGIN;
INSERT INTO `test` VALUES ('1', 'gøse'), ('2', 'b'), ('3', 'c');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
