-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 24 sep. 2024 à 17:19
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
-- Base de données : `board game tournament`
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

-- --------------------------------------------------------

--
-- Structure de la table `player_teams`
--

CREATE TABLE `player_teams` (
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `is_substitue` int(1) DEFAULT 0,
  `games_won` int(11) DEFAULT 0,
  `games_lost` int(11) DEFAULT 0,
  `games_tied` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `game_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `team_amount` int(11) NOT NULL,
  `players_per_team` int(11) NOT NULL DEFAULT 1
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
  ADD KEY `game_id` (`game_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `player_tournaments_ibfk_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`),
  ADD CONSTRAINT `player_tournaments_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);

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
  ADD CONSTRAINT `team_tournaments_ibfk_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`),
  ADD CONSTRAINT `team_tournaments_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Contraintes pour la table `tournaments`
--
ALTER TABLE `tournaments`
  ADD CONSTRAINT `tournaments_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
