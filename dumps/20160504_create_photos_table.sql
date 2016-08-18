CREATE TABLE `photos` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
  `albumId` int(11) NOT NULL,
  `slug_filename` varchar(255) CHARACTER SET latin1 NOT NULL,
  `hash_filename` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `desc` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `featured` tinyint(4) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `photoscol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
