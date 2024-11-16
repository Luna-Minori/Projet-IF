-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 16 nov. 2024 à 16:06
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
(4, 'Catan', 'bb', 1, 2, 8, 0, 0),
(5, 'chess', 'bb', 0, 2, 2, 0, 0),
(10, 'Uno', '', 0, 0, 0, 0, 0),
(11, '', '', 0, 0, 0, 0, 0);

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
(1, 4, 0, 0, 0),
(1, 5, 0, 0, 0),
(19, 1, 0, 0, 0),
(19, 4, 0, 0, 0),
(21, 1, 0, 0, 0);

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
(19, 'pelo1', '2024-11-12', NULL, 'pelo1@pelo.test', '$2y$10$.cbuKLnZ36rPTpgGM9WVLumVcQs/4OntUPJfa7M2ry0Bp8C1M0n2S', 0, 0, 0),
(20, 'pelo2@pelo.test', '2024-11-12', NULL, 'pelo2@pelo.test', '$2y$10$QAFuIV/D99ttcEVN7vUYPeYrN01NAWf4iJk1Up28u.Shn72Du8dwK', 0, 0, 0),
(21, 'pelo3', '2024-11-12', NULL, 'pelo3@pelo.test', '$2y$10$4qRHNpePa7tYH4R0fXBSc.TxCE6imerAebj5OjKj1h2bh1l5cQFcK', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `player_match_tournaments`
--

CREATE TABLE `player_match_tournaments` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `player1_id` int(11) DEFAULT 0,
  `player2_id` int(11) DEFAULT 0,
  `round` tinyint(1) DEFAULT 0,
  `win` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `player_match_tournaments`
--

INSERT INTO `player_match_tournaments` (`id`, `tournament_id`, `player1_id`, `player2_id`, `round`, `win`) VALUES
(1, 6, 1, NULL, 0, 1);

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
(1, 10, 0, 1, '2024-11-12 11:48:45', 0, 0, 0),
(1, 11, 0, 1, '2024-11-15 19:15:01', 0, 0, 0),
(1, 13, 0, 1, '2024-11-16 11:19:17', 0, 0, 0),
(1, 14, 0, 1, '2024-11-16 11:23:10', 0, 0, 0),
(1, 15, 0, 1, '2024-11-16 11:24:30', 0, 0, 0),
(1, 16, 0, 1, '2024-11-16 11:25:08', 0, 0, 0),
(1, 17, 0, 1, '2024-11-16 11:26:15', 0, 0, 0),
(1, 18, 0, 1, '2024-11-16 11:28:54', 0, 0, 0),
(19, 10, 0, 0, '2024-11-12 11:52:55', 0, 0, 0),
(19, 12, 0, 1, '2024-11-15 19:37:53', 0, 0, 0),
(20, 10, 0, 0, '2024-11-12 11:52:57', 0, 0, 0),
(21, 10, 0, 0, '2024-11-12 11:53:35', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `player_tournaments`
--

CREATE TABLE `player_tournaments` (
  `tournament_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `Administrator` int(11) DEFAULT NULL,
  `Date_joined` date NOT NULL DEFAULT current_timestamp(),
  `round` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `player_tournaments`
--

INSERT INTO `player_tournaments` (`tournament_id`, `player_id`, `score`, `Administrator`, `Date_joined`, `round`) VALUES
(6, 1, 0, 2, '2024-11-12', 0),
(7, 19, 0, 2, '2024-11-15', 0),
(8, 19, 0, 2, '2024-11-15', 0),
(9, 19, 0, 2, '2024-11-15', 0),
(10, 19, 0, 2, '2024-11-15', 0);

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
(10, 'Best chessplayers', '2024-11-12', 1, NULL, 5, 0, 0, 0),
(11, 'Catan players', '2024-11-15', 1, NULL, 4, 0, 0, 0),
(12, 'Unooo', '2024-11-15', 19, NULL, 10, 0, 0, 0),
(13, 'test', '2024-11-16', 1, NULL, 1, 0, 0, 0),
(14, 'test2', '2024-11-16', 1, NULL, 4, 0, 0, 0),
(15, 'test3', '2024-11-16', 1, NULL, 5, 0, 0, 0),
(16, 'test4', '2024-11-16', 1, NULL, 1, 0, 0, 0),
(17, 'test5', '2024-11-16', 1, NULL, 1, 0, 0, 0),
(18, 'Test6', '2024-11-16', 1, NULL, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `team_match_tournaments`
--

CREATE TABLE `team_match_tournaments` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `team1_id` int(11) DEFAULT 0,
  `team2_id` int(11) DEFAULT 0,
  `round` tinyint(1) DEFAULT 0,
  `win` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(6, 19, 10, '2024-11-12 11:49:49', 1),
(7, 20, 10, '2024-11-12 11:51:21', 1),
(8, 20, 10, '2024-11-12 11:51:46', 1),
(9, 21, 10, '2024-11-12 11:52:13', 1);

-- --------------------------------------------------------

--
-- Structure de la table `team_tournaments`
--

CREATE TABLE `team_tournaments` (
  `tournament_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `Administrator` int(11) DEFAULT NULL,
  `Date_joined` date NOT NULL DEFAULT current_timestamp(),
  `round` int(11) DEFAULT 0
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
  `Register_time` int(11) DEFAULT NULL,
  `Creation_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator_id` int(11) DEFAULT NULL,
  `History` tinyint(1) DEFAULT 0,
  `round` int(11) DEFAULT 0,
  `Rules` varchar(255) DEFAULT NULL,
  `tournament_tree` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tournaments`
--

INSERT INTO `tournaments` (`id`, `Name`, `game_id`, `Match_system`, `participant`, `Register_time`, `Creation_Date`, `creator_id`, `History`, `round`, `Rules`, `tournament_tree`) VALUES
(6, 'Chess worldcup', 5, 1, 1, 3600, '2024-11-12 12:28:10', 1, 1, 7, NULL, 0),
(7, 'Chess', 5, 1, 1, 604800, '2024-11-15 19:39:52', 19, 0, 0, NULL, 0),
(8, 'Unooo', 10, 1, 1, 86400, '2024-11-15 19:46:12', 19, 0, 0, NULL, 0),
(9, 'Catan tournament', 4, 1, 1, 259200, '2024-11-15 19:47:08', 19, 0, 0, NULL, 0),
(10, 'Osu', 1, 1, 1, 43200, '2024-11-15 19:50:03', 19, 0, 0, NULL, 0);

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
-- Index pour la table `player_match_tournaments`
--
ALTER TABLE `player_match_tournaments`
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
-- Index pour la table `team_match_tournaments`
--
ALTER TABLE `team_match_tournaments`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `player_match_tournaments`
--
ALTER TABLE `player_match_tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `team_match_tournaments`
--
ALTER TABLE `team_match_tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `team_request`
--
ALTER TABLE `team_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
