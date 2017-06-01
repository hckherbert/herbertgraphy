-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: hg_main
-- ------------------------------------------------------
-- Server version	5.6.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_code` varchar(32) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `intro` text,
  `visible` tinyint(1) DEFAULT '1',
  `view_count` int(11) DEFAULT NULL,
  `privatekey` varchar(100) DEFAULT NULL,
  `aspect_ratio` float DEFAULT '1.5',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
  `photo_code` varchar(32) DEFAULT NULL,
  `albumId` int(11) NOT NULL,
  `album_code` varchar(32) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `slug_filename` varchar(255) NOT NULL,
  `hash_filename` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` varchar(1000) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  `highlighted` tinyint(1) DEFAULT '0',
  `view_count` int(11) DEFAULT NULL,
  `exif` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB AUTO_INCREMENT=1403 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-25 12:11:50
