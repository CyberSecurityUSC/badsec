grant all on injection.* to someguy@'%' identified by 'n4styliz4rd' with grant option; 

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
	INSERT INTO `secrets` VALUES ('2b32c98f8a5540e1f0444a7192eff247');
	INSERT INTO `secrets` VALUES ('b646d30ff79f54221175874985779da3');

UNLOCK TABLES;