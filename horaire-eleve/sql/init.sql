-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 24 sep. 2026 à 01:15
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `horaire`
--
CREATE DATABASE IF NOT EXISTS horaire;
USE horaire;
-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `annee_scolaire` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `nom`, `annee_scolaire`) VALUES
(74, 'P2A', '2025-2026'),
(75, 'P3A', '2026-2027'),
(76, 'P3B', '2026-2027');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `nom` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `code`, `nom`) VALUES
(10, 'AWEB', ' Atelier Web'),
(11, 'A', ' Atelier'),
(12, 'C#', 'C#');

-- --------------------------------------------------------

--
-- Structure de la table `creneaux`
--

CREATE TABLE `creneaux` (
  `id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL,
  `cours_id` int(11) NOT NULL,
  `jour` varchar(20) DEFAULT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `salle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `creneaux`
--

INSERT INTO `creneaux` (`id`, `classe_id`, `cours_id`, `jour`, `heure_debut`, `heure_fin`, `salle`) VALUES
(23, 74, 10, 'Lundi', '08:05:00', '11:40:00', '15'),
(24, 74, 11, 'Lundi', '12:40:00', '16:10:00', '15'),
(25, 75, 12, 'Mardi', '08:05:00', '11:40:00', '15'),
(26, 75, 11, 'Lundi', '08:05:00', '11:40:00', '12'),
(27, 74, 10, 'Lundi', '12:40:00', '16:10:00', '12'),
(28, 75, 12, 'Vendredi', '08:05:00', '11:40:00', '12'),
(29, 76, 10, 'Mercredi', '12:40:00', '16:10:00', '15'),
(30, 76, 11, 'Mercredi', '08:05:00', '11:40:00', '12'),
(31, 76, 10, 'Jeudi', '08:05:00', '11:40:00', '15');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `creneaux`
--
ALTER TABLE `creneaux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classe_id` (`classe_id`),
  ADD KEY `cours_id` (`cours_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `creneaux`
--
ALTER TABLE `creneaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `creneaux`
--
ALTER TABLE `creneaux`
  ADD CONSTRAINT `creneaux_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `creneaux_ibfk_2` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
