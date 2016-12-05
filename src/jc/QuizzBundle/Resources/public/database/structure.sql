
--
-- Structure de la table `quizz`
--

DROP TABLE IF EXISTS `quizz`;
CREATE TABLE `quizz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pictureUrl` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `quizzResponse`
--

DROP TABLE IF EXISTS `quizzResponse`;
CREATE TABLE `quizzResponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quizz_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `responses` longtext DEFAULT NULL,
  `positionX` int(11) NOT NULL,
  `positionY` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
