-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 17 Novembre 2016 à 17:01
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ajax`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `token`, `created_at`, `role`) VALUES
(1, 'choupipek', 'jeremy.touyon@live.fr', '$2y$10$JmdB6leN.m3KPCzFvW8S5uTLRMuS5KqghVcdkT4dkNFOm7oOY3Q5y', 'Um19rcneJiUxvX6aZ4VHTWPfqqNojS', '2016-11-17 12:10:55', 'user'),
(2, 'geelik', 'thibault.picard@gmail.com', '$2y$10$oatD8qCuxd088CozP3Ej.e/q9QMHmcGj0TIrhV..PC39HuFFsc0tG', 'dM7ilywgQPU9klCsSiw85rWE3XJYmA', '2016-11-17 12:15:32', 'user'),
(3, 'lelou', 'lelou@gmail.com', '$2y$10$vnEVgB34SZKIMonMtSmjJ.g0xFrsAwZpXz5O211xOmkJTxKcfWMfa', 'X3lOQl972U7pB04C9kleL6Od13N23n', '2016-11-17 12:19:05', 'user'),
(4, 'jessyRoi', 'jessy.leroy@live.fr', '$2y$10$scTtPqy9xH2F1vnugrhJY.Vdmb7A.8i6yEIvGbYatAbALKFj4XkeS', 'OUMPaAa93NWHzMYqjfAOnpCOmZrUkd', '2016-11-17 15:10:58', 'user');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
