-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 04 Janvier 2017 à 07:49
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `paris-oise`
--

-- --------------------------------------------------------

--
-- Structure de la table `construction`
--

DROP TABLE IF EXISTS `construction`;
CREATE TABLE `construction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(55) NOT NULL,
  `firstname1` varchar(255) DEFAULT NULL,
  `lastname1` varchar(255) DEFAULT NULL,
  `birthDate1` datetime DEFAULT NULL,
  `birthPlace1` varchar(255) DEFAULT NULL,
  `nationality1` varchar(55) DEFAULT NULL,
  `job1` varchar(255) DEFAULT NULL,
  `phone1` varchar(55) DEFAULT NULL,
  `mail1` varchar(255) DEFAULT NULL,
  `firstname2` varchar(255) DEFAULT NULL,
  `lastname2` varchar(255) DEFAULT NULL,
  `birthDate2` datetime DEFAULT NULL,
  `birthPlace2` varchar(255) DEFAULT NULL,
  `nationality2` varchar(55) DEFAULT NULL,
  `job2` varchar(255) DEFAULT NULL,
  `phone2` varchar(55) DEFAULT NULL,
  `mail2` varchar(255) DEFAULT NULL,
  `customerUnion` varchar(55) DEFAULT NULL,
  `customerStreet1` varchar(255) DEFAULT NULL,
  `customerStreet2` varchar(255) DEFAULT NULL,
  `customerZip` varchar(10) DEFAULT NULL,
  `customerCity` varchar(55) DEFAULT NULL,
  `constructionStreet1` varchar(255) DEFAULT NULL,
  `constructionStreet2` varchar(255) DEFAULT NULL,
  `constructionZip` varchar(10) DEFAULT NULL,
  `constructionCity` varchar(55) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `depositDate1` datetime DEFAULT NULL,
  `depositDate2` datetime DEFAULT NULL,
  `validateDate` datetime DEFAULT NULL,
  `signDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_DC91E26EAEA34913` (`reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(55) DEFAULT NULL,
  `mobile` varchar(55) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `construction_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contact_type`
--

DROP TABLE IF EXISTS `contact_type`;
CREATE TABLE `contact_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(55) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `construction_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document_type`
--

DROP TABLE IF EXISTS `document_type`;
CREATE TABLE `document_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document_file`
--

DROP TABLE IF EXISTS `document_file`;
CREATE TABLE `document_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` longtext NOT NULL,
  `uploadDate` datetime DEFAULT NULL,
  `document_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `status` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `street1` varchar(255) DEFAULT NULL,
  `street2` varchar(255) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `city` varchar(55) DEFAULT NULL,
  `trade` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
