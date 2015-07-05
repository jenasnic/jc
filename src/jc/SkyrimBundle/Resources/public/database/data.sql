﻿
--
-- Contenu de la table `effect`
--

INSERT INTO `effect` (`id`, `name`) VALUES
(1, 'destruction de magie'),
(2, 'destruction de santé'),
(3, 'frénésie'),
(4, 'invisibilité'),
(5, 'langueur'),
(6, 'paralysie'),
(7, 'pénalité de magie'),
(8, 'pénalité de magie persistante'),
(9, 'pénalité de récupération de vigueur'),
(10, 'pénalité de regain magique'),
(11, 'pénalité de santé'),
(12, 'pénalité de santé persistante'),
(13, 'pénalité de vigueur'),
(14, 'pénalité de vigueur persistante'),
(15, 'pénalité de vigueur/ langueur'),
(16, 'peur'),
(17, 'potion médicinale'),
(18, 'récupération de vigueur'),
(19, 'regain de magie'),
(20, 'regain magique'),
(21, 'régénération de magie'),
(22, 'régénération de santé'),
(23, 'renfort d''altération'),
(24, 'renfort d''arme à deux mains'),
(25, 'renfort d''arme à une main'),
(26, 'renfort d''armes à deux mains'),
(27, 'renfort d''armes à une main'),
(28, 'renfort d''armure légère'),
(29, 'renfort d''armure lourde'),
(30, 'renfort d''enchantement'),
(31, 'renfort d''illusion'),
(32, 'renfort de conjuration'),
(33, 'renfort de crochetage'),
(34, 'renfort de destruction'),
(35, 'renfort de forgeage'),
(36, 'renfort de furtivité'),
(37, 'renfort de guérison'),
(38, 'renfort de magie'),
(39, 'renfort de marchandage'),
(40, 'renfort de parade'),
(41, 'renfort de portage'),
(42, 'renfort de précision'),
(43, 'renfort de santé'),
(44, 'renfort de vigueur'),
(45, 'renfort de vol à la tire'),
(46, 'renfort destruction'),
(47, 'renfort vigueur'),
(48, 'résistance à la foudre'),
(49, 'résistance à la glace'),
(50, 'résistance à la magie'),
(51, 'résistance au feu'),
(52, 'résistance au poison'),
(53, 'respiration aquatique'),
(54, 'restauration de magie'),
(55, 'restauration de santé'),
(56, 'restauration de vigueur'),
(57, 'vulnérabilité à la foudre'),
(58, 'vulnérabilité à la glace'),
(59, 'vulnérabilité à la magie'),
(60, 'vulnérabilité au feu'),
(61, 'vulnérabilité au poison');

--
-- Contenu de la table `ingredient`
--

INSERT INTO `ingredient` (`id`, `name`) VALUES
(1, 'Abeille'),
(2, 'Abecéen à longues nageoires'),
(3, 'Ail'),
(4, 'Aile de fléchette bleue'),
(5, 'Aile de fléchette orange'),
(6, 'Aile de noctuelle'),
(7, 'Aile de papillon'),
(8, 'Aile de papillon bleu'),
(9, 'Amanite tue mouches'),
(10, 'Bec de faucon'),
(11, 'Bernache nordique'),
(12, 'Blé'),
(13, 'Carpe du Hist'),
(14, 'Chapeau blanc'),
(15, 'Chair humaine'),
(16, 'Chitine de vasard'),
(17, 'Cloquerille'),
(18, 'Coeur de Daedra'),
(19, 'Coeur de ronces'),
(20, 'Coeur humain'),
(21, 'Cosse'),
(22, 'Coton sauvage'),
(23, 'Couronne sanglante'),
(24, 'Dent de Smilodon'),
(25, 'Dent de spectre de glace'),
(26, 'Ecailles de poisson carnassier'),
(27, 'Ectoplasme'),
(28, 'Farine d''os'),
(29, 'Genièvres'),
(30, 'Graisse de troll'),
(31, 'Grelot-de-la-mort'),
(32, 'Griffe d''ours'),
(33, 'Givreboises'),
(34, 'Grande ramure'),
(35, 'Hivernelle'),
(36, 'Huile Dwemer'),
(37, 'Langue de Dragon'),
(38, 'Lavande'),
(39, 'Lichen géant'),
(40, 'Lys des cimes bleu'),
(41, 'Lys des cimes rouges'),
(42, 'Lys des cimes violet'),
(43, 'Mora Tapinella'),
(44, 'Mousse Barbue'),
(45, 'Nirnroot'),
(46, 'Obscurcine'),
(47, 'Oeil de Smilodon'),
(48, 'Oeuf d''araignée'),
(49, 'Oeuf de poisson carnassier'),
(50, 'Oeuf de fauvette'),
(51, 'Oeuf de grive'),
(52, 'Oeuf de poule'),
(53, 'Oeuf de Chaurus'),
(54, 'Oreille d''elfe'),
(55, 'Oreille de Falmer'),
(56, 'Orteil géant'),
(57, 'Perche Argentée'),
(58, 'Peau de Ragnard carbonisée'),
(59, 'Petite ramure'),
(60, 'Perle'),
(61, 'Pholiotes à écailles'),
(62, 'Pied-de-lutin'),
(63, 'Plantes grimpantes'),
(64, 'Plume d''Harfreuse'),
(65, 'Plume de faucon'),
(66, 'Poudre de défense de mammouth'),
(67, 'Poisson-Combattant de Cyrodiil'),
(68, 'Poisson de rivière'),
(69, 'Poussière luisante'),
(70, 'Poussière de vampire'),
(71, 'Queue de Ragnard'),
(72, 'Racine de Canis'),
(73, 'Racine noueuse'),
(74, 'Raisin Jazbay'),
(75, 'Rayon de miel'),
(76, 'Ruche vide'),
(77, 'Sels de feu'),
(78, 'Sels de givre'),
(79, 'Sel du néant'),
(80, 'Serre d''Harfreuse'),
(81, 'Sève de Spriggan'),
(82, 'Sucrelune'),
(83, 'Tas de sel'),
(84, 'Thorax de Flammouche'),
(85, 'Tige de chardon'),
(86, 'Truffe de Namira'),
(87, 'Voiles éthérés');

--
-- Contenu de la table `ingredient_effect`
--

INSERT INTO `ingredient_effect` (`id_ingredient`, `id_effect`) VALUES
(31, 11),
(31, 15),
(31, 61),
(62, 11),
(62, 6),
(62, 12),
(12, 55),
(12, 43),
(12, 13),
(12, 7),
(12, 8),
(8, 13),
(8, 32),
(8, 7),
(8, 10),
(8, 30),
(1, 56),
(1, 13),
(1, 18),
(1, 57),
(2, 58),
(2, 36),
(2, 61),
(2, 37),
(3, 52),
(3, 44),
(3, 20),
(3, 22),
(4, 48),
(4, 45),
(4, 55),
(4, 16),
(5, 56),
(5, 1),
(5, 45),
(5, 12),
(6, 7),
(6, 28),
(6, 22),
(6, 4),
(7, 55),
(7, 39),
(7, 8),
(7, 7),
(9, 51),
(9, 26),
(9, 3),
(9, 18),
(10, 56),
(10, 49),
(10, 41),
(10, 48),
(11, 7),
(11, 53),
(11, 22),
(11, 45),
(13, 56),
(13, 38),
(13, 9),
(13, 53),
(14, 58),
(14, 29),
(14, 54),
(14, 1),
(15, 11),
(15, 6),
(15, 54),
(15, 36),
(16, 56),
(16, 17),
(16, 52),
(16, 51),
(17, 13),
(17, 3),
(17, 55),
(17, 35),
(18, 55),
(18, 9),
(18, 7),
(18, 16),
(19, 54),
(19, 40),
(19, 6),
(19, 38),
(20, 11),
(20, 10),
(20, 7),
(20, 3),
(21, 52),
(21, 1),
(21, 23),
(21, 54),
(22, 50),
(22, 38),
(22, 40),
(22, 39),
(23, 60),
(23, 40),
(23, 61),
(23, 50),
(24, 56),
(24, 29),
(24, 35),
(24, 61),
(25, 58),
(25, 29),
(25, 4),
(25, 60),
(26, 49),
(26, 12),
(26, 29),
(26, 40),
(27, 54),
(27, 34),
(27, 38),
(27, 11),
(28, 13),
(28, 51),
(28, 32),
(28, 13),
(29, 60),
(29, 42),
(29, 22),
(29, 9),
(30, 52),
(30, 26),
(30, 3),
(30, 11),
(32, 56),
(32, 43),
(32, 25),
(32, 10),
(33, 51),
(33, 30),
(33, 49),
(33, 48),
(34, 56),
(34, 44),
(34, 5),
(34, 9),
(35, 49),
(35, 36),
(35, 1),
(35, 9),
(36, 59),
(36, 20),
(36, 31),
(36, 54),
(37, 51),
(37, 39),
(37, 31),
(37, 24),
(38, 50),
(38, 44),
(38, 1),
(38, 32),
(39, 11),
(39, 61),
(39, 57),
(39, 54),
(40, 55),
(40, 32),
(40, 43),
(40, 10),
(41, 54),
(41, 38),
(41, 7),
(41, 11),
(42, 56),
(42, 36),
(42, 10),
(42, 49),
(43, 54),
(43, 12),
(43, 18),
(43, 31),
(44, 7),
(44, 1),
(44, 43),
(44, 27),
(45, 11),
(45, 13),
(45, 4),
(45, 50),
(46, 11),
(46, 7),
(46, 14),
(46, 34),
(47, 56),
(47, 8),
(47, 2),
(47, 55),
(48, 13),
(48, 7),
(48, 33),
(48, 42),
(49, 52),
(49, 40),
(49, 12),
(49, 44),
(50, 55),
(50, 25),
(50, 13),
(50, 59),
(51, 56),
(51, 33),
(51, 61),
(51, 48),
(52, 50),
(52, 7),
(52, 53),
(52, 14),
(53, 61),
(53, 47),
(53, 7),
(53, 4),
(54, 54),
(54, 42),
(54, 58),
(54, 51),
(55, 52),
(55, 11),
(55, 52),
(55, 33),
(56, 13),
(56, 43),
(56, 41),
(56, 9),
(57, 56),
(57, 9),
(57, 11),
(57, 49),
(58, 56),
(58, 17),
(58, 52),
(58, 55),
(59, 61),
(59, 37),
(59, 14),
(59, 11),
(60, 56),
(60, 54),
(60, 40),
(60, 48),
(61, 59),
(61, 31),
(61, 18),
(61, 41),
(63, 54),
(63, 9),
(63, 41),
(63, 59),
(64, 7),
(64, 3),
(64, 32),
(64, 57),
(65, 17),
(65, 28),
(65, 25),
(65, 36),
(66, 56),
(66, 60),
(66, 36),
(66, 16),
(67, 13),
(67, 37),
(67, 16),
(67, 11),
(68, 11),
(68, 23),
(68, 5),
(68, 41),
(69, 7),
(69, 10),
(69, 34),
(69, 48),
(70, 4),
(70, 54),
(70, 22),
(70, 17),
(71, 9),
(71, 2),
(71, 11),
(71, 28),
(72, 13),
(72, 25),
(72, 42),
(72, 6),
(73, 59),
(73, 31),
(73, 20),
(73, 54),
(74, 59),
(74, 38),
(74, 20),
(74, 11),
(75, 56),
(75, 40),
(75, 28),
(75, 13),
(76, 52),
(76, 28),
(76, 36),
(76, 46),
(77, 58),
(77, 54),
(77, 51),
(77, 19),
(78, 60),
(78, 49),
(78, 54),
(78, 32),
(79, 57),
(79, 50),
(79, 11),
(79, 38),
(80, 50),
(80, 8),
(80, 30),
(80, 39),
(81, 10),
(81, 30),
(81, 35),
(81, 23),
(82, 21),
(82, 49),
(82, 54),
(82, 60),
(83, 59),
(83, 37),
(83, 5),
(83, 20),
(84, 56),
(84, 8),
(84, 59),
(84, 44),
(85, 49),
(85, 13),
(85, 52),
(85, 29),
(86, 7),
(86, 33),
(86, 16),
(86, 22),
(87, 56),
(87, 34),
(87, 41),
(87, 50);