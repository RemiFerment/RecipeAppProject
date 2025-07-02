-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 29 juin 2025 à 17:09
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `recipeapp`
--

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient_recipe`
--

CREATE TABLE `ingredient_recipe` (
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `unit_measure_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recipe`
--

CREATE TABLE `recipe` (
  `ID` int(11) NOT NULL,
  `user_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `unit_measure`
--

CREATE TABLE `unit_measure` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `UUID` char(36) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(60) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`UUID`, `pseudo`, `email`, `password`, `created_at`) VALUES
('13a0e0de-5336-11f0-9ca4-581122c7a692', 'aa', 'aaa@aa.aa', '$2y$10$IE6PqanYAv/3DiB0PO.5QOu7eNjQsoSrXtjTgYddTw4eaHwJ3Mvo.', '2025-06-27'),
('3d806bf6-53e3-11f0-9ca4-581122c7a692', 'zz', 'ferment.remi.pro@gmail.comzzz', '$2y$10$4VpF20o0HZnrs0Orsqa2geKYuAKMxRjlPnEQqjfqNvq2E8yyaw7TS', '2025-06-28'),
('522e5bbe-5336-11f0-9ca4-581122c7a692', 'aa', 'aaaa@aaa.aa', '$2y$10$fuzU5v1TkHdWhII6n8IP6eNEuUCPMDVz1dvXmXo6YHImRPyNvnora', '2025-06-27'),
('6a4bbc94-540b-11f0-9ca4-581122c7a692', 'Les champs des mots de passe ne correspondent pas.', 'ferment.remi.pro@gmail.comaaaaaaaaaaaaaaaaaaa', '$2y$10$IItgg3NpS/wxtvviTdaQsuipvc98pZ.B1jCWy0AzmSK2d7F12qKa.', '2025-06-28'),
('6bdc9634-5339-11f0-9ca4-581122c7a692', 'zz', 'kairada@gmail.comzz', '$2y$10$rB/3cG9hymiZTyN8wDxdU.2W6mfol28v8s.gx4JA/EZZdPw5cjakC', '2025-06-27'),
('87106f8d-5336-11f0-9ca4-581122c7a692', 'aa', 'dd@dd.dds', '$2y$10$AhKrpFHocHO7QCbvaG.YuefjzOXMxu.wQusYZdJFBOk.MkS0HJCvu', '2025-06-27'),
('9d8389f3-5272-11f0-9ca4-581122c7a692', 'Ferment', 'ferment.remi.pro@gmail.com', '$2y$10$FDd.eK8hwXvWWQ.W/HZhSOFP/k4Qb/TWjXMmTKfvkz.XBZp..w64S', '2025-06-26'),
('a867410f-5336-11f0-9ca4-581122c7a692', 'aa', 'ferment.remi.pro@gmail.coma', '$2y$10$F1S9EjO1SxtKKRkIuB1Wte36d1K423pDY4gXz7I.J0u8jtrExj0WK', '2025-06-27'),
('d5cca52f-52d6-11f0-9ca4-581122c7a692', 'test', 'test@test.test', '$2y$10$QAI8JG2GEeYv8didc8C1Z.tv2.XF9HLphBYEUMIyrngYcgKoTsbqm', '2025-06-26');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ingredient_recipe`
--
ALTER TABLE `ingredient_recipe`
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `unit_measure_id` (`unit_measure_id`);

--
-- Index pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `unit_measure`
--
ALTER TABLE `unit_measure`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UUID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `unit_measure`
--
ALTER TABLE `unit_measure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ingredient_recipe`
--
ALTER TABLE `ingredient_recipe`
  ADD CONSTRAINT `ingredient_recipe_ibfk_1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`),
  ADD CONSTRAINT `ingredient_recipe_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`ID`),
  ADD CONSTRAINT `ingredient_recipe_ibfk_3` FOREIGN KEY (`unit_measure_id`) REFERENCES `unit_measure` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
