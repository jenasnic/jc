
--
-- Structure de la table `effect`
--

DROP TABLE IF EXISTS `effect`;
CREATE TABLE IF NOT EXISTS `effect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nameFR` varchar(55) NOT NULL,
  `nameEN` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nameFR` varchar(55) NOT NULL,
  `nameEN` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient_effect`
--

DROP TABLE IF EXISTS `ingredient_effect`;
CREATE TABLE IF NOT EXISTS `ingredient_effect` (
  `id_ingredient` int(11) NOT NULL,
  `id_effect` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

