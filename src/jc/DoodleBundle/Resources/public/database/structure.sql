
--
-- Structure de la table `doodle`
--

DROP TABLE IF EXISTS `doodle`;
CREATE TABLE `doodle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `comment` text DEFAULT NULL,
  `eventDate` datetime NOT NULL,
  `replyDate` datetime DEFAULT NULL,
  `sent` tinyint(1) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `doodleReply`
--

DROP TABLE IF EXISTS `doodleReply`;
CREATE TABLE `doodleReply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doodleId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `response` tinyint(1) NOT NULL,
  `comment` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
