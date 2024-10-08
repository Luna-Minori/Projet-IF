-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 08 oct. 2024 à 14:47
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
-- Base de données : `player_test.sql`
--

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `hashed_password` varchar(72) NOT NULL,
  `games_won` int(11) DEFAULT 0,
  `games_lost` int(11) DEFAULT 0,
  `games_tied` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `players`
--

INSERT INTO `players` (`id`, `username`, `creation_date`, `bio`, `email`, `hashed_password`, `games_won`, `games_lost`, `games_tied`) VALUES
(1, 'pelo1', '2024-10-08', 'test test test', 'pelo1@test.com', '1234567890', 0, 0, 0),
(2, 'pelo2', '2024-10-08', 'test test test test test test', 'pelo2@test.com', '2234567890', 0, 0, 0),
(3, 'pelo3', '2024-10-08', 'test test test test test test test test test', 'pelo3@test.com', '3234567890', 0, 0, 0),
(4, 'pelo4', '2024-10-08', 'test test test test test test test test test test test test', 'pelo4@test.com', '4234567890', 0, 0, 0),
(5, 'pelo5', '2024-10-08', 'test test test test test test test test test test test test test test test', 'pelo5@test.com', '5234567890', 0, 0, 0),
(6, 'pelo6', '2024-10-08', 'test test test test test test test test test test test test test test test test test test', 'pelo6@test.com', '6234567890', 0, 0, 0),
(7, 'pelo7', '2024-10-08', 'test test test test test test test test test test test test test test test test test test test test test', 'pelo7@test.com', '7234567890', 0, 0, 0),
(8, 'pelo8', '2024-10-08', 'test test test', 'pelo8@test.com', '8234567890', 0, 0, 0),
(9, 'pelo9', '2024-10-08', 'test test test', 'pelo9@test.com', '9234567890', 0, 0, 0),
(10, 'pelo10', '2024-10-08', 'test test test', 'pelo110@test.com', '10234567890', 0, 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
