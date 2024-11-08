-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 08 nov. 2024 à 21:26
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
-- Base de données : `board_game_tournament`
--

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `rules` text NOT NULL,
  `team_based` int(1) NOT NULL COMMENT 'false = single-player',
  `min_teams` int(11) NOT NULL,
  `max_teams` int(11) NOT NULL COMMENT 'must be >  	min_teams ',
  `min_players_in_teams` int(11) NOT NULL COMMENT 'ignored if not a team game',
  `max_players_in_teams` int(11) NOT NULL COMMENT 'must be > min_players_in_teams'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`id`, `title`, `rules`, `team_based`, `min_teams`, `max_teams`, `min_players_in_teams`, `max_players_in_teams`) VALUES
(1, 'Osu', 'aa', 0, 1, 1000, 0, 0),
(2, '0', '0', 1, 0, 0, 0, 0),
(3, '0', '0', 1, 0, 0, 0, 0),
(4, 'Catan', 'bb', 1, 2, 8, 0, 0),
(5, 'chess', 'bb', 0, 2, 2, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `played_games`
--

CREATE TABLE `played_games` (
  `player_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `games_won` int(11) DEFAULT 0,
  `games_lost` int(11) DEFAULT 0,
  `games_tied` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `played_games`
--

INSERT INTO `played_games` (`player_id`, `game_id`, `games_won`, `games_lost`, `games_tied`) VALUES
(1, 1, 0, 0, 0),
(1, 2, 0, 0, 0),
(1, 3, 0, 0, 0),
(1, 4, 0, 0, 0),
(1, 5, 0, 0, 0);

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
(1, 'Minori', '2024-10-01', 'Hi l am minori l am kind of playing board game', 'luna@utbm', '$2y$10$78TTJwFcArBKHd3g8Ml2Se5gwC3EgW2T9fSvTksnuk9twJC6DrdB.', 0, 0, 0),
(2, 'tao', '2024-10-08', 'tao bio', 'tao@utbm', 'hefuaheu', 0, 0, 0),
(5, 'pelo1', '2024-10-08', 'test test test', 'pelo1@test.com', '1234567890', 0, 0, 0),
(6, 'pelo1', '2024-10-08', 'test test test', 'pelo1@test.com', '1234567890', 0, 0, 0),
(7, 'pelo2', '2024-10-08', 'test test test test test test', 'pelo2@test.com', '2234567890', 0, 0, 0),
(8, 'pelo3', '2024-10-08', 'test test test test test test test test test', 'pelo3@test.com', '3234567890', 0, 0, 0),
(9, 'pelo4', '2024-10-08', 'test test test test test test test test test test test test', 'pelo4@test.com', '4234567890', 0, 0, 0),
(10, 'pelo5', '2024-10-08', 'test test test test test test test test test test test test test test test', 'pelo5@test.com', '5234567890', 0, 0, 0),
(11, 'pelo6', '2024-10-08', 'test test test test test test test test test test test test test test test test test test', 'pelo6@test.com', '6234567890', 0, 0, 0),
(12, 'pelo7', '2024-10-08', 'test test test test test test test test test test test test test test test test test test test test test', 'pelo7@test.com', '7234567890', 0, 0, 0),
(13, 'pelo8', '2024-10-08', 'test test test', 'pelo8@test.com', '8234567890', 0, 0, 0),
(14, 'pelo9', '2024-10-08', 'test test test', 'pelo9@test.com', '9234567890', 0, 0, 0),
(15, 'pelo10', '2024-10-08', 'test test test', 'pelo110@test.com', '10234567890', 0, 0, 0),
(16, 'pelo99', '2024-10-22', NULL, 'pelo99@utbm.fr', '$2y$10$9OYYhx8r7UXHSTSjoxZps.7GKLyEZJjnVB.N2p0cSe9aag3F0zrD6', 0, 0, 0),
(17, 'pik', '2024-10-26', NULL, 'pik@gmail', '$2y$10$/NY64SqTqVFKm2/yDd5bTOR6dFj3ymrGEswwj7Y.AbxTo.w8Izl5e', 0, 0, 0),
(18, 'juki', '2024-10-26', NULL, 'juki@kop', '$2y$10$Bx6s9mlEObo2ImCd6LNkju7kEbcEJYgYgQqPDlqwFCp4qgcgva8eK', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `player_teams`
--

CREATE TABLE `player_teams` (
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `is_substitue` int(1) DEFAULT 0,
  `Administrator` tinyint(1) DEFAULT 0,
  `Date_joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `games_won` int(11) DEFAULT 0,
  `games_lost` int(11) DEFAULT 0,
  `games_tied` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `player_teams`
--

INSERT INTO `player_teams` (`player_id`, `team_id`, `is_substitue`, `Administrator`, `Date_joined`, `games_won`, `games_lost`, `games_tied`) VALUES
(1, 9, 0, 1, '2024-11-07 12:24:02', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `player_tournaments`
--

CREATE TABLE `player_tournaments` (
  `tournament_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `creation_date` date DEFAULT curdate(),
  `creator_id` int(11) NOT NULL,
  `bio` text DEFAULT NULL,
  `game_id` int(11) NOT NULL,
  `games_won` int(11) DEFAULT 0,
  `games_lost` int(11) DEFAULT 0,
  `games_tied` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `teams`
--

INSERT INTO `teams` (`id`, `title`, `creation_date`, `creator_id`, `bio`, `game_id`, `games_won`, `games_lost`, `games_tied`) VALUES
(1, 'Moki', '2024-11-04', 1, 'best', 1, 0, 0, 0),
(2, 'lopi', '2024-11-04', 2, 'best', 2, 0, 0, 0),
(3, 'julu', '2024-11-04', 1, 'best', 4, 0, 0, 0),
(4, 'phu', '2024-11-04', 1, 'best', 3, 0, 0, 0),
(6, 'ezfhbjq', '2024-11-05', 1, NULL, 1, 0, 0, 0),
(7, 'Test1', '2024-11-07', 1, NULL, 1, 0, 0, 0),
(8, 'Test2', '2024-11-07', 1, NULL, 1, 0, 0, 0),
(9, 'Test3', '2024-11-07', 1, NULL, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `team_request`
--

CREATE TABLE `team_request` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `treated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `team_request`
--

INSERT INTO `team_request` (`id`, `player_id`, `team_id`, `Date`, `treated`) VALUES
(1, 1, 9, '2024-11-08 13:28:07', 1),
(2, 1, 9, '2024-11-08 13:40:38', 1),
(3, 1, 9, '2024-11-08 13:56:46', 1),
(4, 1, 9, '2024-11-08 13:59:28', 1),
(5, 1, 9, '2024-11-08 16:40:06', 1);

-- --------------------------------------------------------

--
-- Structure de la table `team_tournaments`
--

CREATE TABLE `team_tournaments` (
  `tournament_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tournaments`
--

CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `game_id` int(11) NOT NULL,
  `Match_system` tinyint(1) NOT NULL,
  `participant` tinyint(4) NOT NULL,
  `Register_time` tinyint(1) NOT NULL,
  `Creation_Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tournaments`
--

INSERT INTO `tournaments` (`id`, `Name`, `game_id`, `Match_system`, `participant`, `Register_time`, `Creation_Date`) VALUES
(1, 'Test1', 1, 2, 1, 1, '2024-11-08 18:18:07'),
(2, 'Test2', 1, 1, 1, 6, '2024-11-08 18:19:32');

-- --------------------------------------------------------

--
-- Structure de la table `tournament_request`
--

CREATE TABLE `tournament_request` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT 0,
  `team_id` int(11) DEFAULT 0,
  `tournament_id` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `treated` tinyint(1) DEFAULT 0,
  `Creator_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `played_games`
--
ALTER TABLE `played_games`
  ADD PRIMARY KEY (`player_id`,`game_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Index pour la table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `player_teams`
--
ALTER TABLE `player_teams`
  ADD PRIMARY KEY (`player_id`,`team_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Index pour la table `player_tournaments`
--
ALTER TABLE `player_tournaments`
  ADD PRIMARY KEY (`tournament_id`,`player_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Index pour la table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Index pour la table `team_request`
--
ALTER TABLE `team_request`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `team_tournaments`
--
ALTER TABLE `team_tournaments`
  ADD PRIMARY KEY (`tournament_id`,`team_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Index pour la table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_game_id` (`game_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `team_request`
--
ALTER TABLE `team_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `played_games`
--
ALTER TABLE `played_games`
  ADD CONSTRAINT `played_games_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `played_games_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

--
-- Contraintes pour la table `player_teams`
--
ALTER TABLE `player_teams`
  ADD CONSTRAINT `player_teams_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `player_teams_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Contraintes pour la table `player_tournaments`
--
ALTER TABLE `player_tournaments`
  ADD CONSTRAINT `player_tournaments_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `player_tournaments_ibfk_3` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`);

--
-- Contraintes pour la table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `players` (`id`),
  ADD CONSTRAINT `teams_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

--
-- Contraintes pour la table `team_tournaments`
--
ALTER TABLE `team_tournaments`
  ADD CONSTRAINT `team_tournaments_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `team_tournaments_ibfk_3` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`);

--
-- Contraintes pour la table `tournaments`
--
ALTER TABLE `tournaments`
  ADD CONSTRAINT `fk_game_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
