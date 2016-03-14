grant select, insert on injection.* to someguy@'%' identified by 'n4styliz4rd' with grant option; 

/* Posts Table */
DROP TABLE IF EXISTS `injection`;
CREATE TABLE `injection` (
  `idea` longtext COLLATE latin1_general_ci NOT NULL,
  `time` varchar(80) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/* Seed */
LOCK TABLES `injection` WRITE;

	INSERT INTO `injection` VALUES ('Hello World','1381862715');

UNLOCK TABLES;


/* Secrets Table*/
DROP TABLE IF EXISTS `secrets`;
CREATE TABLE `secrets` (
  `secret` longtext COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/* Seed */
LOCK TABLES `secrets` WRITE;

	INSERT INTO `secrets` VALUES ('This was too easy huh?');
	INSERT INTO `secrets` VALUES ('118073a6f72f4337172db076da98fb0427a0aeef4f624e681db7368e7e839708');

UNLOCK TABLES;