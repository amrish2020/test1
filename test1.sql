-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.31 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for test1
DROP DATABASE IF EXISTS `test1`;
CREATE DATABASE IF NOT EXISTS `test1` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `test1`;

-- Dumping structure for table test1.doclist
DROP TABLE IF EXISTS `doclist`;
CREATE TABLE IF NOT EXISTS `doclist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_parent` (`parent_id`),
  CONSTRAINT `fk_category_parent` FOREIGN KEY (`parent_id`) REFERENCES `doclist` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table test1.filepath
DROP TABLE IF EXISTS `filepath`;
CREATE TABLE IF NOT EXISTS `filepath` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for function test1.getpath
DROP FUNCTION IF EXISTS `getpath`;
DELIMITER //
CREATE FUNCTION `getpath`(cat_id INT) RETURNS text CHARSET latin1
    DETERMINISTIC
BEGIN
    DECLARE res TEXT;
    CALL getpath(cat_id, res);
    RETURN res;
END//
DELIMITER ;

-- Dumping structure for procedure test1.getpath
DROP PROCEDURE IF EXISTS `getpath`;
DELIMITER //
CREATE PROCEDURE `getpath`(
	IN `cat_id` INT,
	OUT `path` TEXT
)
BEGIN
    DECLARE catname VARCHAR(20);
    DECLARE temppath TEXT;
    DECLARE tempparent INT;
    SET max_sp_recursion_depth = 255;
    SELECT name, parent_id FROM doclist WHERE id=cat_id INTO catname, tempparent;
    IF tempparent IS NULL
    THEN
        SET path = catname;
    ELSE
        CALL getpath(tempparent, temppath);
        SET path = CONCAT(temppath, '\\', catname);
    END IF;
END//
DELIMITER ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
