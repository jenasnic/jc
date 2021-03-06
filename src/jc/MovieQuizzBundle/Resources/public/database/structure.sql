
--
-- Structure de la table `movieQuizz`
--

DROP TABLE IF EXISTS `movieQuizz`;
CREATE TABLE `movieQuizz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pictureUrl` text DEFAULT NULL,
  `displayResponse` tinyint(1) NOT NULL,
  `displayTrick` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `movieQuizzResponse`
--

DROP TABLE IF EXISTS `movieQuizzResponse`;
CREATE TABLE `movieQuizzResponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quizz_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `responses` longtext DEFAULT NULL,
  `trick` longtext DEFAULT NULL,
  `positionX` int(11) DEFAULT 0,
  `positionY` int(11) DEFAULT 0,
  `size` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `movieQuizzWinner`
--

DROP TABLE IF EXISTS `movieQuizzWinner`;
CREATE TABLE `movieQuizzWinner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quizz_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  `date` datetime NOT NULL,
  `trickCount` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
