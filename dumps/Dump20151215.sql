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
  `order` int(11) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `intro` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` VALUES (1,1,NULL,'first','first-label','orem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet aliquam nisl. Curabitur consectetur ut odio sed sollicitudin. Sed dictum magna arcu, eget tristique dui tincidunt a. Aliquam porttitor ligula aliquet, fermentum ex ac, euismod mi. Su'),(2,2,NULL,'Parent','travel','This is a parent album'),(3,3,NULL,'sunset','sunset',''),(4,4,2,'turkey','van','van lake'),(5,5,NULL,'lego','lego','lego!'),(6,6,NULL,'lego2','lego2',''),(7,7,NULL,'portrait','portrait','hello ar good morning'),(8,8,NULL,'travel','travel','solo');
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
  `albumId` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` varchar(1000) NOT NULL,
  `featured` tinyint(4) NOT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
INSERT INTO `photos` VALUES (1,1,'DSC_0490_1443241266.jpg','','',0),(2,1,'DSC_0491_1443241267.jpg','','',0),(3,1,'DSC_0502_1443241268.jpg','','',0),(4,1,'DSC_0548_1443241268.jpg','Tit de la foto','le descriptione',0),(6,1,'DSC_1636_1443241638.jpg','','',0),(7,1,'DSC_1643_1443241639.jpg','','',0),(8,1,'DSC_1655_1443241639.jpg','','',0),(9,1,'DSC_2096_1443241640.jpg','','',0),(10,1,'DSC_2126_1443241640.jpg','','',0),(11,1,'DSC_2329_1443241640.jpg','','',0),(12,1,'movie_1444012645.jpg','','',0),(13,1,'DSC_0096_1444012646.jpg','wawel','',0),(15,1,'train_1444012775.jpg','','',0),(18,1,'DSC_1121_1444013046.jpg','Gdansk','house!',0),(19,1,'DSC_0183_1444013090.jpg','Krakow','snow',0),(20,1,'clock_sunset_1444013091.jpg','','',0),(21,1,'DSC_1147_1444013124.jpg','','',0),(22,1,'DSC_0050_1444013145.jpg','','',0),(24,1,'DSC_0743_1444013146.jpg','','',0),(25,1,'DSC_0016_1444013276.jpg','','',0),(26,1,'DSC_0250_1444013276.jpg','Warsaw','hey hey',0),(27,1,'DSC_0310_1444013277.jpg','','',0),(29,1,'DSC_0118_1444013326.jpg','','',0),(30,1,'DSC_0219_1444013327.jpg','','',0),(32,1,'DSC_0535_1444013533.jpg','Van Lake','stunning!',0),(33,1,'DSC_0575_1444013533.jpg','Van Church','great!',0),(34,1,'DSC_0608_1444013534.jpg','','',0),(36,1,'DSC_0513_1444013603.jpg','Van lake','like movie scene?',0),(38,1,'29_1444014259.jpg','','',0),(40,1,'DSC_0828_1444015087.jpg','Krakow','carriage!',0),(42,1,'DSC_0924_1444015265.JPG','Capital','good',0),(43,1,'DSC_0365_1444015815.jpg','','',0),(44,1,'DSC_0420_1444015815.jpg','','',0),(45,1,'DSC_0330_1444021144.jpg','','',0),(46,1,'DSC_0552_1444021145.jpg','','',0),(47,1,'DSC_0705_1444021145.jpg','','',0),(48,1,'DSC_0707_1444021146.jpg','','',0),(49,1,'DSC_0752_1444021146.jpg','','',0),(50,1,'DSC_0765_1444021146.jpg','','',0),(51,1,'DSC_0869_1444021147.jpg','','',0),(52,1,'DSC_0872_1444021147.jpg','','',0),(53,1,'DSC_0910_1444021148.jpg','','',0),(54,3,'mui_mui_1444039248.jpg','mui mui','cuteeee',1),(55,3,'2_1444039249.jpg','','',0),(56,3,'3_1444039249.jpg','','',0),(57,3,'4_1444039250.jpg','','',0),(58,3,'5_1444039250.jpg','','',0),(59,3,'6_1444039250.jpg','','',0),(60,3,'6a_1444039251.jpg','','',0),(61,3,'6b_1444039251.jpg','','',0),(62,3,'7a_1444039252.jpg','','',0),(63,3,'7b_1444039252.jpg','','',0),(64,3,'8_1444039253.jpg','','',0),(65,3,'8b_1444039253.jpg','','',0),(66,3,'8c_1444039253.jpg','','',0),(67,3,'9_1444039254.jpg','','',0),(68,3,'10_1444039254.jpg','','',0),(69,3,'11_1444039255.jpg','','',0),(70,3,'12_1444039255.jpg','','',0),(71,3,'13_1444039255.jpg','','',0),(72,3,'14_1444039256.jpg','','',0),(73,3,'14b_1444039256.jpg','','',0),(74,3,'14c_1444039257.jpg','','',0),(75,3,'14d_1444039257.jpg','','',0),(76,3,'14e_1444039257.jpg','','',0),(77,3,'15_1444039258.jpg','','',0),(78,3,'16_1444039258.jpg','','',0),(79,3,'17_1444039259.jpg','','',0),(80,3,'18_1444039259.jpg','','',0),(81,3,'18b_1444039260.jpg','','',0),(82,3,'19_1444039260.jpg','','',0),(83,3,'20_1444039260.jpg','','',0),(84,3,'21_1444039261.jpg','','',0),(85,3,'21b_1444039261.jpg','','',0),(86,3,'22_1444039261.jpg','','',0),(87,3,'23_1444039262.jpg','','',0),(88,3,'24_1444039262.jpg','','',0),(89,3,'24a_1444039262.jpg','','',0),(90,3,'24b_1444039263.jpg','','',0),(91,3,'24c_1444039263.jpg','','',0),(92,3,'25_1444039264.jpg','','',0),(93,3,'26_1444039264.jpg','','',0),(94,3,'27_1444039264.jpg','','',0),(95,3,'28_1444039265.jpg','','',0),(96,3,'29_1444039265.jpg','','',0),(97,3,'30_1444039265.jpg','','',0),(98,3,'31_1444039266.jpg','','',0),(99,3,'31b_1444039266.jpg','','',0),(100,3,'32a_1444039266.jpg','','',0),(101,3,'32b_1444039267.jpg','','',0),(102,3,'32c_1444039267.jpg','','',0),(103,3,'32d_1444039267.jpg','','',0),(104,3,'33_1444039268.jpg','','',0),(105,3,'33b_1444039268.jpg','','',0),(106,3,'33c_1444039268.jpg','','',0),(107,3,'33d_1444039269.jpg','','',0),(108,3,'33e_1444039269.jpg','','',0),(109,3,'35_1444039270.jpg','','',0),(110,3,'36_1444039270.jpg','','',0),(111,3,'36b_1444039270.jpg','','',0),(112,3,'37_1444039270.jpg','','',0),(113,3,'38_1444039271.jpg','','',0),(114,3,'39_1444039271.jpg','','',0),(115,3,'40_1444039271.jpg','','',0),(116,3,'41_1444039271.jpg','','',0),(117,3,'42_1444039272.jpg','','',0),(118,3,'43_1444039272.jpg','','',0),(119,3,'44_1444039272.jpg','','',0),(120,3,'44a_1444039273.jpg','','',0),(121,3,'45_1444039273.jpg','','',0),(122,3,'46_1444039273.jpg','','',0),(123,3,'47_1444039274.jpg','','',0),(124,3,'48_1444039274.jpg','','',0),(125,3,'49_1444039275.jpg','','',0),(126,3,'50_1444039275.jpg','','',0),(127,3,'51_1444039275.jpg','','',0),(128,3,'52_1444039276.jpg','','',0),(129,3,'52b_1444039276.jpg','','',0),(130,3,'52c_1444039276.jpg','','',0),(131,3,'52d_1444039277.jpg','','',0),(132,3,'53_1444039277.jpg','','',0),(133,3,'54_1444039278.jpg','','',0),(134,5,'DSC_0424_1444039882.jpg','','',0),(135,5,'DSC_0428_1444039883.jpg','','',0),(136,5,'DSC_0432_1444039883.jpg','','',0),(137,5,'DSC_0436_1444039883.jpg','','',0),(138,5,'DSC_0447_1444039884.jpg','','',0),(139,5,'DSC_0448_1444039884.jpg','','',0),(140,5,'DSC_0454_1444039885.jpg','','',0),(141,5,'DSC_0456_1444039885.jpg','','',0),(142,5,'DSC_0460_1444039886.jpg','','',0),(143,5,'DSC_0465_1444039886.jpg','','',0),(144,5,'DSC_0479_1444039888.jpg','','',0),(145,5,'DSC_0485_1444039888.jpg','','',0),(146,5,'DSC_0486_1444039889.jpg','','',0),(147,5,'DSC_0487_1444039890.jpg','','',0),(148,5,'DSC_0488_1444039890.jpg','','',0),(149,5,'DSC_0491_1444039891.jpg','','',0),(150,5,'DSC_0495_1444039892.jpg','','',0),(151,5,'DSC_0506_1444039892.jpg','','',0),(152,5,'DSC_0513_1444039892.jpg','','',0),(153,5,'DSC_0519_1444039893.jpg','','',0),(154,5,'DSC_0524_1444039893.jpg','','',0),(155,5,'DSC_0535_1444039894.jpg','','',0),(156,5,'DSC_0539_1444039894.jpg','','',0),(157,5,'DSC_0544_1444039895.jpg','','',0),(158,5,'DSC_0547_1444039896.jpg','','',0),(159,5,'DSC_0548_1444039896.jpg','','',0),(160,5,'DSC_0551_1444039896.jpg','','',0),(161,5,'DSC_0553_1444039897.jpg','','',0),(162,5,'DSC_0567_1444039899.jpg','','',0),(163,5,'DSC_0569_1444039901.jpg','','',0),(164,5,'DSC_0570_1444039903.jpg','','',0),(165,5,'DSC_0572_1444039905.jpg','','',0),(166,5,'DSC_0573_1444039907.jpg','','',0),(167,5,'DSC_0575_1444039909.jpg','','',0),(168,5,'DSC_0576_1444039911.jpg','','',0),(169,5,'DSC_0578_1444039913.jpg','','',0),(170,5,'DSC_0595_1444039915.jpg','','',0),(171,5,'DSC_0600_1444039917.jpg','','',1),(172,5,'DSC_0606_1444039919.jpg','','',0),(173,5,'DSC_0608_1444039921.jpg','','',0),(174,4,'sunset-airport-track0_1444040117.jpg','','',0),(175,4,'sunset-airport-track1_1444040118.jpg','','',0),(176,4,'sunset-causeway-bay0_1444040118.jpg','','',0),(177,4,'sunset-causeway-bay1_1444040119.jpg','','',0),(178,4,'sunset-citygate1_1444040119.jpg','','',0),(179,4,'sunset-citygate2_1444040119.jpg','','',0),(180,4,'sunset-citygate3_1444040119.jpg','','',0),(181,4,'sunset-citygate4_1444040120.jpg','','',0),(182,4,'sunset-citygate5_1444040120.jpg','','',0),(183,4,'sunset-kwun-tong-waterfront0_1444040120.jpg','','',0),(184,4,'sunset-kwun-tong-waterfront1_1444040121.jpg','','',0),(185,4,'sunset-lau-fau-shan0_1444040121.jpg','','',0),(186,4,'sunset-lau-fau-shan1_1444040121.jpg','','',0),(187,4,'sunset-lau-fau-shan2_1444040122.jpg','','',0),(188,4,'sunset-lung-ku-tan0_1444040122.jpg','','',0),(189,4,'sunset-lung-ku-tan1_1444040122.jpg','','',0),(190,4,'sunset-lung-ku-tan2_1444040122.jpg','','',0),(191,4,'sunset-lung-ku-tan3_1444040123.jpg','','',0),(192,4,'sunset-nam-sun-wai_1444040124.jpg','','',0),(193,4,'sunset-pak-nai0_1444040125.jpg','','',0),(194,4,'sunset-pak-nai1_1444040126.jpg','','',0),(195,4,'sunset-pak-nai2_1444040126.jpg','','',0),(196,4,'sunset-puio0_1444040127.jpg','','',0),(197,4,'sunset-sandy-bay_1444040127.jpg','','',0),(198,4,'sunset-swimming-shed0_1444040128.jpg','','',0),(199,4,'sunset-taio0_1444040128.jpg','','',1),(200,4,'sunset-taio1_1444040129.jpg','','',0),(201,4,'sunset-tsing-lung-tau0_1444040129.jpg','','',0),(202,4,'sunset-tungchung0_1444040130.jpg','','',0),(203,4,'sunset-tungchung1_1444040131.jpg','','',0),(204,4,'sunset-tungchung2_1444040131.jpg','','',0),(205,4,'sunset-tungchung3_1444040131.jpg','','',0),(206,4,'sunset-tungchung4_1444040132.jpg','','',0),(207,6,'lego-herbert-10218-pet-shop0_1444040495.jpg','','',0),(208,6,'lego-herbert-10218-pet-shop1_1444040495.jpg','','',0),(209,6,'lego-herbert-10218-pet-shop2_1444040495.jpg','','',0),(210,6,'lego-herbert-10218-pet-shop3_1444040495.jpg','','',0),(211,6,'lego-herbert-10218-pet-shop4_1444040496.jpg','','',0),(212,6,'lego-herbert-10218-pet-shop5_1444040496.jpg','','',0),(213,6,'lego-herbert-10218-pet-shop6_1444040496.jpg','','',0),(214,6,'lego-herbert-10243-parisian-restaurant0_1444040496.jpg','','',0),(215,6,'lego-herbert-10243-parisian-restaurant1_1444040497.jpg','','',0),(216,6,'lego-herbert-10243-parisian-restaurant2_1444040497.jpg','','',0),(217,6,'lego-herbert-10243-parisian-restaurant3_1444040497.jpg','','',0),(218,6,'lego-herbert-10243-parisian-restaurant4_1444040498.jpg','','',0),(219,6,'lego-herbert-10243-parisian-restaurant5_1444040498.jpg','','',0),(220,6,'lego-herbert-10243-parisian-restaurant6_1444040498.jpg','','',0),(221,6,'lego-herbert-10243-parisian-restaurant7_1444040500.jpg','','',0),(222,6,'lego-herbert-10243-parisian-restaurant8_1444040502.jpg','','',0),(223,6,'lego-herbert-10243-parisian-restaurant9_1444040504.jpg','','',0),(224,6,'lego-herbert-10243-parisian-restaurant10_1444040506.jpg','','',0),(225,6,'lego-herbert-10243-parisian-restaurant11_1444040508.jpg','','',0),(226,6,'lego-herbert-10243-parisian-restaurant12_1444040510.jpg','','',0),(227,6,'lego-herbert-10243-parisian-restaurant13_1444040512.jpg','','',0),(228,6,'lego-herbert-31012-town-house_1444040514.jpg','','',0),(229,6,'lego-herbert-judas-betray-jesus_1444040516.jpg','','',0),(230,6,'lego-herbert-mary-saw-jesus_1444040518.jpg','','',0),(231,6,'lego-herbert-railyway-museum0_1444040520.jpg','','',0),(232,6,'lego-herbert-railyway-museum1_1444040522.jpg','','',0),(233,6,'lego-herbert-sleepyhead0_1444040524.jpg','','',0),(234,6,'lego-herbert-sleepyhead1_1444040526.jpg','','',0),(235,6,'lego-herbert-sleepyhead2_1444040528.jpg','','',1),(236,6,'lego-herbert-sleepyhead3_1444040530.jpg','','',0),(237,6,'lego-herbert-sleepyhead4_1444040532.jpg','','',0),(238,6,'lego-herbert-sleepyhead5_1444040534.jpg','','',0),(239,7,'lego-herbert-judas-betray-jesus_1444041037.jpg','','',0),(240,7,'lego-herbert-mary-saw-jesus_1444041038.jpg','','',0),(241,7,'lego-herbert-railyway-museum0_1444041038.jpg','','',0),(242,7,'lego-herbert-railyway-museum1_1444041039.jpg','','',0),(243,7,'lego-herbert-sleepyhead0_1444041039.jpg','','',0),(244,7,'lego-herbert-sleepyhead1_1444041040.jpg','','',0),(245,7,'lego-herbert-sleepyhead2_1444041040.jpg','','',0),(246,7,'lego-herbert-sleepyhead3_1444041041.jpg','','',0),(247,7,'lego-herbert-sleepyhead4_1444041041.jpg','','',0),(248,7,'lego-herbert-sleepyhead5_1444041041.jpg','','',0),(249,7,'lego-herbert-town0_1444041042.jpg','','',0),(250,7,'lego-herbert-town1_1444041042.jpg','','',0),(251,7,'lego-herbert-town2_1444041042.jpg','','',0),(252,7,'lego-herbert-town3_1444041042.jpg','','',0);
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-15 14:36:02
