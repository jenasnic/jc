
--
-- Structure de la table `englishWord`
--

DROP TABLE IF EXISTS `englishWord`;
CREATE TABLE `englishWord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nameEN` varchar(55) NOT NULL,
  `nameFR` varchar(255) DEFAULT NULL,
  `lesson` int(11) DEFAULT 0,
  `page` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nameEN` (`nameEN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `englishIrregularVerb`
--

DROP TABLE IF EXISTS `englishIrregularVerb`;
CREATE TABLE `englishIrregularVerb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `verbEN` varchar(55) NOT NULL,
  `verbFR` varchar(55) DEFAULT NULL,
  `preterit` varchar(55) NOT NULL,
  `past` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `verbEN` (`verbEN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure de la table `englishExpression`
--

DROP TABLE IF EXISTS `englishExpression`;
CREATE TABLE `englishExpression` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `textEN` varchar(255) NOT NULL,
  `textFR` varchar(255) DEFAULT NULL,
  `lesson` int(11) DEFAULT 0,
  `page` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `textEN` (`textEN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
