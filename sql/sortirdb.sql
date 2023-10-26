-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 26 oct. 2023 à 17:39
-- Version du serveur : 8.0.31
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sortirdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `campus`
--

DROP TABLE IF EXISTS `campus`;
CREATE TABLE IF NOT EXISTS `campus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9D0968116C6E55B5` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `campus`
--

INSERT INTO `campus` (`id`, `nom`) VALUES
(2, 'Nantes'),
(3, 'Paris'),
(1, 'Toulouse');

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_55CAF762A4D60759` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
(4, 'Activité en cours'),
(6, 'Annulée'),
(3, 'Clôturée'),
(1, 'Créée'),
(2, 'Ouverte'),
(5, 'passée');

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ville_id` int DEFAULT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rue` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2F577D59A73F0036` (`ville_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id`, `ville_id`, `nom`, `rue`, `latitude`, `longitude`) VALUES
(1, 1, 'Campus Toulouse', 'Avenue nicom', 43, 1.2637),
(2, 2, 'Campus Nante', 'rue 1', NULL, NULL),
(3, 3, 'Campus Paris', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

DROP TABLE IF EXISTS `participant`;
CREATE TABLE IF NOT EXISTS `participant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `campus_id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL,
  `administrateur` tinyint(1) NOT NULL,
  `pseudo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D79F6B11E7927C74` (`email`),
  UNIQUE KEY `UNIQ_D79F6B1186CC499D` (`pseudo`),
  KEY `IDX_D79F6B11AF5D55E1` (`campus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant`
--

INSERT INTO `participant` (`id`, `campus_id`, `email`, `mot_passe`, `nom`, `prenom`, `telephone`, `actif`, `administrateur`, `pseudo`, `image`) VALUES
(1, 1, 'user@user.fr', '$2y$13$Y1nn0XdYJjZDg7fmvOkaGuZKgo0VhH7XM0Xfvug2NxbopqmdSF2MG', 'user', 'user', NULL, 1, 0, 'user', ''),
(3, 1, 'admin@admin.fr', '$2y$13$Y1nn0XdYJjZDg7fmvOkaGuZKgo0VhH7XM0Xfvug2NxbopqmdSF2MG', 'admin', 'admin', NULL, 1, 1, 'admin', ''),
(5, 1, 'nicom@nicom.fr', '$2y$13$ssbAedodCHO9uRJ41R0kReV/HqudF1ReBkfaY8hm6RbJqjXU7xiAO', 'nicom', 'nicom', '0611121314', 1, 1, 'nicom', 'nicom-6537faea4a809.jpg'),
(6, 2, 'test@test.fr', '$2y$13$klV1S0pherUMWsRa1zUviuZga8yNQtyWgeo724RZ0rBiNp0fA/Hhy', 'test', 'test', NULL, 1, 0, 'test', ''),
(7, 3, 'User3@User3.fr', '$2y$13$A.JySdGx7XxijUVa8RH/LeSXKfJ/i23YiP7WCREWZSY6qrqmH5Mmm', 'User3', 'User3', NULL, 1, 0, 'User3', NULL),
(8, 2, 'User2@User2.fr', '$2y$13$POEAPvVNDaXVIMPzrYVuyevOjq6nwx9xcmbppFUfjYThpEI4vI2yi', 'User2', 'User2', NULL, 1, 0, 'User2', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

DROP TABLE IF EXISTS `sortie`;
CREATE TABLE IF NOT EXISTS `sortie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `etat_id` int NOT NULL,
  `lieu_id` int NOT NULL,
  `campus_id` int NOT NULL,
  `organisateur_id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_debut` datetime NOT NULL,
  `duree` int NOT NULL,
  `date_limite_inscription` date NOT NULL,
  `nb_inscriptions_max` int NOT NULL,
  `infos_sortie` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3C3FD3F2D5E86FF` (`etat_id`),
  KEY `IDX_3C3FD3F26AB213CC` (`lieu_id`),
  KEY `IDX_3C3FD3F2AF5D55E1` (`campus_id`),
  KEY `IDX_3C3FD3F2D936B2FA` (`organisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`id`, `etat_id`, `lieu_id`, `campus_id`, `organisateur_id`, `nom`, `date_heure_debut`, `duree`, `date_limite_inscription`, `nb_inscriptions_max`, `infos_sortie`) VALUES
(1, 1, 1, 1, 1, 'Apéro', '2023-10-18 09:20:45', 6, '2023-10-28', 100, 'Apéro étudiant ....'),
(2, 2, 2, 2, 6, 'Ballade', '2023-10-23 12:51:21', 2, '2023-10-26', 50, 'Ballade en foret'),
(3, 1, 1, 1, 5, 'Sortie Theatre', '2023-11-23 12:52:35', 2, '2023-10-31', 20, 'Sortie theatre'),
(4, 3, 1, 1, 5, 'Ballade en péniche', '2023-11-23 12:54:26', 1, '2023-10-27', 10, 'Ballade en péniche'),
(5, 4, 2, 2, 5, 'Sortie Theatre', '2023-10-23 14:18:29', 2, '2023-10-04', 20, 'Sortie Theatre'),
(6, 2, 3, 3, 5, 'Sortie Theatre', '2023-10-23 14:22:43', 2, '2023-10-11', 30, 'Sortie Theatre'),
(7, 5, 1, 1, 5, 'Rafting', '2023-10-23 15:42:01', 2, '2023-10-16', 10, 'Rafting'),
(8, 1, 1, 2, 5, 'test', '2023-10-26 00:00:00', 1, '2023-10-27', 1, 'test'),
(9, 2, 1, 2, 5, 'nouvelle sortie', '2023-11-05 00:00:00', 2, '2023-11-01', 10, 'Test création sortie'),
(10, 1, 1, 1, 5, 'Test2', '2023-11-03 00:00:00', 1, '2023-11-01', 10, 'nb places 10\r\ndurée 1'),
(11, 4, 1, 1, 8, 'SortieTest2', '2023-11-16 19:33:35', 120, '2023-11-01', 10, 'Test'),
(12, 1, 1, 1, 5, 'TestSortie3', '2023-11-28 00:00:00', 271, '2023-11-07', 10, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `sortie_participant`
--

DROP TABLE IF EXISTS `sortie_participant`;
CREATE TABLE IF NOT EXISTS `sortie_participant` (
  `sortie_id` int NOT NULL,
  `participant_id` int NOT NULL,
  PRIMARY KEY (`sortie_id`,`participant_id`),
  KEY `IDX_E6D4CDADCC72D953` (`sortie_id`),
  KEY `IDX_E6D4CDAD9D1C3019` (`participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sortie_participant`
--

INSERT INTO `sortie_participant` (`sortie_id`, `participant_id`) VALUES
(1, 1),
(2, 3),
(2, 5),
(3, 1),
(3, 3),
(3, 5),
(3, 6),
(4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom`, `code_postal`) VALUES
(1, 'Toulouse', '31000'),
(2, 'Nante', '44000'),
(3, 'Paris', '75000');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD CONSTRAINT `FK_2F577D59A73F0036` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `FK_D79F6B11AF5D55E1` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`id`);

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD CONSTRAINT `FK_3C3FD3F26AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2AF5D55E1` FOREIGN KEY (`campus_id`) REFERENCES `campus` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2D5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2D936B2FA` FOREIGN KEY (`organisateur_id`) REFERENCES `participant` (`id`);

--
-- Contraintes pour la table `sortie_participant`
--
ALTER TABLE `sortie_participant`
  ADD CONSTRAINT `FK_E6D4CDAD9D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E6D4CDADCC72D953` FOREIGN KEY (`sortie_id`) REFERENCES `sortie` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
