
--
-- Structure de la table `staticText`
--

DROP TABLE IF EXISTS `staticText`;
CREATE TABLE `staticText` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `code` varchar(55) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
