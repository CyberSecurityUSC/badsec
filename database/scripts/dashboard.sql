grant select, insert on dashboard.* to board@'%' identified by '4221175874985779da3' with grant option; 

/* Points Table */
DROP TABLE IF EXISTS `points`;
CREATE TABLE `points` (
  `name`  longtext COLLATE latin1_general_ci NOT NULL,
  `pass`  longtext COLLATE latin1_general_ci NOT NULL,
  `keyid` MEDIUMINT NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


/* Seed */
LOCK TABLES `points` WRITE;

	INSERT INTO `points` VALUES ('Example Sam','1381862715', 1);

UNLOCK TABLES;

/* Secrets Table*/
DROP TABLE IF EXISTS `flags`;
CREATE TABLE `flags` (
  `id` MEDIUMINT AUTO_INCREMENT NOT NULL,
  `description` longtext COLLATE latin1_general_ci NOT NULL,
  `secret` longtext COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/* Seed */
LOCK TABLES `flags` WRITE;

	INSERT INTO `flags` VALUES (NULL, 'Can you read? I hope you can read. Maybe you should read some.'  ,'iReadTheThingAndTheThingSaidToEnterThis');

  # Trivia
  INSERT INTO `flags` VALUES (NULL, 'Ubuntu LTS 16.04 (No spaces, all lower)'                         ,'xenialxerus');
  INSERT INTO `flags` VALUES (NULL, 'Name the goat (All lower)'                                       ,'buttermilk');

  # Serverside
  INSERT INTO `flags` VALUES (NULL, 'Are you a yes man? Why, why, why, why, why?'                     ,'9fde2b54a5fda40c8e5c8e8fad49c15e');
  INSERT INTO `flags` VALUES (NULL, 'Find this flag in it\'s natural enviroment.'                     ,'155e1f69c21613ec8ebca4304ad9847b');
	INSERT INTO `flags` VALUES (NULL, 'This key might be "processed"'                                   ,'1f6c3c93811036733dda17515d378ecb');
  INSERT INTO `flags` VALUES (NULL, 'MYSQL keeps a history too.'                                      ,'5bd6e98e1369d551dc1eb7a805c0a074');

  # Inject
  INSERT INTO `flags` VALUES (NULL, 'Look under the covers.'                                          ,'826e13ba7a7fa26448ceadff62022c31154c725ce324bc188c37b364801d395e');
  INSERT INTO `flags` VALUES (NULL, 'Grab the key from the "secrets" table'                           ,'118073a6f72f4337172db076da98fb0427a0aeef4f624e681db7368e7e839708');  
  INSERT INTO `flags` VALUES (NULL, 'Inside of little Bobby'                                          ,'D32SdiRDKea8NVthFlYi');

  # Request
  INSERT INTO `flags` VALUES (NULL, 'A bad commit'                                                    ,'8e956177b6d3ca7bc32c3aaa6e446171fc19865b');
  INSERT INTO `flags` VALUES (NULL, 'A worse commit'                                                  ,'ea283db39adc67848dfc196963890f8b2033a1be');

  # Chuck
  INSERT INTO `flags` VALUES (NULL, 'MD5 my worst joke.'                                              ,'0cab39f94a3b56a8f25a020d16b97235');
  INSERT INTO `flags` VALUES (NULL, 'MD5 my best joke.'                                               ,'0cf2d89601d53698392219e435c72861');
  INSERT INTO `flags` VALUES (NULL, 'MD5 my hidden joke.'                                             ,'38b2c91f8312c0fc82d101c0857e6500');

	INSERT INTO `flags` VALUES (NULL, 'Bug Bounty. Yay you.'                                            ,'DamnitDylanDamnit');

UNLOCK TABLES;