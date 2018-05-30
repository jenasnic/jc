-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 04 Janvier 2017 à 08:11
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `paris-oise`
--

--
-- Contenu de la table `contact_type`
--

INSERT INTO `contact_type` (`id`, `label`, `rank`) VALUES
(1, 'Mairie', 1),
(2, 'D.D.E.', 2),
(3, 'A.B.F.', 3),
(4, 'Notaire.', 4),
(5, 'Hydrogéologue', 5),
(6, 'Agence/Propriétaire', 6),
(7, 'Géomètre', 7),
(8, 'Banque', 8);

--
-- Contenu de la table `document_type`
--

INSERT INTO `document_type` (`id`, `label`, `required`, `rank`) VALUES
(1, 'Pré-contrat', 1, 1),
(2, 'Contrat', 1, 2),
(3, 'Notice', 1, 3),
(4, 'Plans', 1, 4),
(5, 'Financement MPO/HOFIA', 1, 5),
(6, 'Financement artisans', 1, 6),
(7, 'Recap financier', 1, 7),
(8, 'Appel fonds H. eau H. air', 1, 8),
(9, 'Attestations D.O. / Financière', 1, 9),
(10, 'Promesse vente terrain', 1, 10),
(11, 'POS - PLU - Règlement lot', 1, 11),
(12, 'Visite terrain', 1, 12),
(13, 'Permis de construire', 1, 13),
(14, 'Attestation BBIOS', 1, 14),
(15, 'Cerfa', 1, 15),
(16, 'Etude assainissement', 1, 16),
(17, 'Procuration PC', 1, 17),
(18, 'Demande devis factures', 1, 18),
(19, 'Fiche C15-100', 1, 19),
(20, 'Grille menuiseries', 1, 20),
(21, 'Devis platrerie', 1, 21),
(22, 'Devis electricité pieuvre', 1, 22),
(23, 'Devis electricité finitions', 1, 23),
(24, 'Devis plomberie', 1, 24),
(25, 'Devis chauffage', 1, 25),
(26, 'Devis branchements terrain', 1, 26),
(27, 'Devis carrelage', 1, 27),
(28, 'Devis étanchéité', 1, 28),
(29, 'Devis escalier', 1, 29);

