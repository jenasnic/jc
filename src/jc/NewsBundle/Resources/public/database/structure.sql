
--
-- Structure de la table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `date` datetime NOT NULL,
  `link` longtext DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `pictureUrl` longtext DEFAULT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
