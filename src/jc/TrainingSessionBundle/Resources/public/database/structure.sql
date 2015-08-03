
--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `civility` varchar(5) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(55) DEFAULT NULL,
  `mobile` varchar(55) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(55) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL,
  `showMap` tinyint(1) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `zoom` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `trainingSession`
--

DROP TABLE IF EXISTS `trainingSession`;
CREATE TABLE `trainingSession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `timeHourStart` int(11) DEFAULT NULL,
  `timeMinuteStart` int(11) DEFAULT NULL,
  `timeHourEnd` int(11) DEFAULT NULL,
  `timeMinuteEnd` int(11) DEFAULT NULL,
  `pictureUrl` text DEFAULT NULL,
  `contactId` int(11) NOT NULL,
  `locationId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `trainingSessionComment`;
CREATE TABLE `trainingSessionComment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `authorId` int(11) NOT NULL,
  `trainingSessionId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
