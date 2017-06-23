-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1:3306
-- Généré le :  Ven 23 Juin 2017 à 09:44
-- Version du serveur :  5.5.24
-- Version de PHP :  7.0.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ihni`
--

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `id` int(11) NOT NULL,
  `pilote_id` int(11) DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `equipe`
--

INSERT INTO `equipe` (`id`, `pilote_id`, `nom`, `createdAt`) VALUES
(1, 4, 'TMA Lybernet', '2017-06-14 09:02:12'),
(2, 5, 'CDS DEFIS', '2017-06-15 09:31:46'),
(3, 3, 'TMA AS 400', '2017-06-15 09:32:12'),
(4, 6, 'CDS SOA Suite', '2017-06-15 09:32:40'),
(5, 10, 'CDS Transverse', '2017-06-15 09:33:09'),
(6, 7, 'CDS Java', '2017-06-15 09:36:19'),
(7, 8, 'at MMA', '2017-06-15 09:37:02'),
(8, 9, 'at Vinci', '2017-06-15 09:37:19');

-- --------------------------------------------------------

--
-- Structure de la table `ihni_user`
--

CREATE TABLE `ihni_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `nom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenom` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `active_at` date DEFAULT NULL,
  `active_until` date DEFAULT NULL,
  `confirmation_status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `ihni_user`
--

INSERT INTO `ihni_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `nom`, `prenom`, `created_at`, `active_at`, `active_until`, `confirmation_status`, `created_by_id`) VALUES
(2, 'nlangen', 'nlangen', 'nlangen@ihni.fr', 'nlangen@ihni.fr', 1, NULL, '$2y$13$J34W6H9KLsZsWdbif.6bG.DNLWz9J6dSpNfQpk9ze4xHjq12rFL6a', '2017-06-22 13:47:05', NULL, NULL, 'a:2:{i:0;s:10:"ROLE_ADMIN";i:1;s:16:"ROLE_SUPER_ADMIN";}', 'Langen', 'Nils', '2017-06-12 13:06:37', NULL, NULL, NULL, NULL),
(3, 'TAnquetil', 'tanquetil', 'tanquetil@ihni.fr', 'tanquetil@ihni.fr', 1, NULL, '$2y$13$piVuLd1s6OpJURmPorbqr.ErjHlzXqwYa6EFRf0xjkG4qVwpg13lu', '2017-06-20 14:28:48', '2c4c78', NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 'Anquetil', 'Thérèse', '2017-06-12 16:46:08', NULL, NULL, NULL, NULL),
(4, 'FThomas', 'fthomas', 'fthomas@ihni.fr', 'fthomas@ihni.fr', 1, NULL, '$2y$13$a.Jky40nlMPWieAuHuD.Ge2gdWg5IijPQkhIzmkb5HQe.w63qxhUW', '2017-06-15 08:49:14', 'UdyramyhdTzlh5UARegl3xElB9dnhCKlA9_9PfemON0', NULL, 'a:0:{}', 'Thomas', 'Franck', '2017-06-14 09:01:33', NULL, NULL, NULL, NULL),
(5, 'NArnaud', 'narnaud', 'narnaud@ihni.fr', 'narnaud@ihni.fr', 0, NULL, '$2y$13$ib49Y6ZN4gpLcZ8i1zFyN.o40t6CsbTNryTheKyp11QN69EYe9Urm', NULL, 'c8d832', NULL, 'a:0:{}', 'Arnaud', 'Nicolas', '2017-06-14 09:09:23', NULL, NULL, NULL, NULL),
(6, 'JDelobel', 'jdelobel', 'jdelobel@ihni.fr', 'jdelobel@ihni.fr', 0, NULL, '$2y$13$j6pTBMohLiisGewJ5wh2Suv5Fqo6M0c.DkgriG/MBOh6U6xmbtD7W', NULL, '332210', NULL, 'a:0:{}', 'Delobel', 'Julien', '2017-06-14 09:10:10', NULL, NULL, NULL, NULL),
(7, 'SBouchet', 'sbouchet', 'sbouchet@ihni.fr', 'sbouchet@ihni.fr', 1, NULL, '$2y$13$L42zJ32rzDWd7rO2/epk/.8pPn0zhCXZuLqeWX8jxktnWATUQz9/.', '2017-06-21 09:05:01', '16b821', NULL, 'a:0:{}', 'Bouchet', 'Sébastien', '2017-06-14 09:11:00', NULL, NULL, NULL, NULL),
(8, 'SChauveau', 'schauveau', 'schauveau@ihni.fr', 'schauveau@ihni.fr', 0, NULL, '$2y$13$nypvcNTA1a00rwjVu0xn8uP3spiZlE5hxpIYhGmf/cx456x..6Qjm', NULL, '9522a0', NULL, 'a:0:{}', 'Chauveau', 'Sandrine', '2017-06-14 09:11:58', NULL, NULL, NULL, NULL),
(9, 'JCarré', 'jcarré', 'jcarre@ihni.fr', 'jcarre@ihni.fr', 0, NULL, '$2y$13$Y.G4lzJLLEDisJxQmqIjROOFlBLtyKwwXS2arloHT6/lL4.aQtoNu', '2017-06-20 08:57:23', NULL, NULL, 'a:0:{}', 'Carré', 'Jerôme', '2017-06-14 09:13:02', NULL, '2017-06-20', NULL, NULL),
(10, 'FKarleskind', 'fkarleskind', 'fkarleskind@ihni.fr', 'fkarleskind@ihni.fr', 0, NULL, '$2y$13$q64RdkiAI0LBzAhE9EwvDugXEAbxvopUUoe/r3imjxPNEmQ9Zq.KS', NULL, '3d2d3a', NULL, 'a:0:{}', 'Karleskind', 'François', '2017-06-15 09:34:05', NULL, NULL, NULL, NULL),
(11, 'PCoignard', 'pcoignard', 'pcoignard@ihni.fr', 'pcoignard@ihni.fr', 0, NULL, '$2y$13$lYFGAkWI6P.AP3DcVpJIUenrhWa1G.ofQAp2Gn85tVanlyAFgZ1EG', NULL, '296451', NULL, 'a:0:{}', 'Coignard', 'Pierre Yves', '2017-06-15 12:32:00', NULL, NULL, NULL, NULL),
(18, 'KEssaghir', 'kessaghir', 'kessaghir@ihni.fr', 'kessaghir@ihni.fr', 1, NULL, '$2y$13$rTE2kqNH1IZIJuC5YhPE1Oj.l94KXlFlf./xkliSgEfPh8EiOly6y', '2017-06-20 08:12:56', NULL, NULL, 'a:0:{}', 'Essaghir', 'Khaoula', '2017-06-15 15:34:48', NULL, NULL, NULL, NULL),
(19, 'ABrochard', 'abrochard', 'abrochard@ihni.fr', 'abrochard@ihni.fr', 1, NULL, '$2y$13$AtcAAWZ.qzzfhgCJmhUfiO9RItyXx8zvOBgyBHzl7YN6zkBNk1eEC', '2017-06-22 08:29:16', NULL, NULL, 'a:0:{}', 'Brochard', 'Allan', '2017-06-15 15:35:58', '2017-06-15', '2017-06-30', 'accepted', NULL),
(20, 'MBeauclair-Renaud', 'mbeauclair-renaud', 'mbeaclair@ihni.fr', 'mbeaclair@ihni.fr', 1, NULL, '$2y$13$9i9EvKa2maNZAOOd27dGb.quhdZfSddBkHpwj17iIe3UuCCFTvJVe', '2017-06-20 13:51:28', NULL, NULL, 'a:0:{}', 'Beauclair-Renaud', 'Magali', '2017-06-20 09:05:25', '2017-06-21', '2017-07-04', 'accepted', NULL),
(21, 'CMontchâtre', 'cmontchâtre', 'cmonchatre@ihni.fr', 'cmonchatre@ihni.fr', 1, NULL, '$2y$13$UUIPNe4004AgLjVrRWQQEOsE8SO2VrgJSa5gTiG13N.h8UDbE5E0C', '2017-06-20 09:28:48', NULL, NULL, 'a:0:{}', 'Montchâtre', 'Carole', '2017-06-20 09:06:16', NULL, NULL, 'accepted', NULL),
(22, 'RHuger', 'rhuger', 'rhuger@ihni.fr', 'rhuger@ihni.fr', 0, NULL, '$2y$13$GY/3nIxoZteOZk33DVk4euooD1isCmiIte3vhIN3z0GnO9ZfIMR3y', NULL, 'yUjBgm2O1YyqEnNZ3AeXnQ9PUBnVqX2bFA2xF0sUt94', NULL, 'a:0:{}', 'Huger', 'Roseline', '2017-06-20 09:18:34', '2017-06-17', '2017-08-24', 'pending', 3),
(23, 'SGuilbert', 'sguilbert', 'sguilbert@ihni.fr', 'sguilbert@ihni.fr', 0, NULL, '$2y$13$sP7hft.BpXflnTpzZkul4uJZsx40C2W1XxFwuZLpHDI.YXGAd/Ity', NULL, 'ea6536', NULL, 'a:0:{}', 'Guilbert', 'Sylvain', '2017-06-20 13:34:01', NULL, NULL, 'pending', 3),
(24, 'KRakhila', 'krakhila', 'krakhila@ihni.fr', 'krakhila@ihni.fr', 0, NULL, '$2y$13$YKQ..vwjHMKmYC0V7qN/u.0PwNPZAyQPcDFb0yXgxtkKkWswXUN/O', NULL, '6e67dc', NULL, 'a:0:{}', 'Rakhila', 'Karim', '2017-06-20 14:21:17', NULL, NULL, 'pending', 3);

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `api_key` varchar(13) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `module`
--

INSERT INTO `module` (`id`, `nom`, `url`, `api_key`) VALUES
(1, 'Sylia', '/sylia', 'f3a7da7e66b0'),
(3, 'Skilex', '/skilex', 'b53d1a6980d5'),
(4, 'TeamTimeline', '/ttimeline', '56dbc36229c4');

-- --------------------------------------------------------

--
-- Structure de la table `module_equipe`
--

CREATE TABLE `module_equipe` (
  `module_id` int(11) NOT NULL,
  `equipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `module_equipe`
--

INSERT INTO `module_equipe` (`module_id`, `equipe_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(3, 6),
(3, 7),
(4, 1),
(4, 3),
(4, 6);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `nom`) VALUES
(1, 'utilisateur'),
(2, 'utilisateur novice');

-- --------------------------------------------------------

--
-- Structure de la table `team_role`
--

CREATE TABLE `team_role` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `equipe_id` int(11) NOT NULL,
  `date_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `team_role`
--

INSERT INTO `team_role` (`id`, `role_id`, `user_id`, `equipe_id`, `date_fin`) VALUES
(1, 1, 11, 6, NULL),
(12, 1, 18, 6, NULL),
(13, 2, 19, 6, '2017-07-13 00:00:00'),
(14, 1, 2, 6, NULL),
(15, 1, 21, 3, NULL),
(16, 1, 22, 1, NULL),
(17, 1, 23, 2, NULL),
(18, 1, 20, 3, NULL),
(19, 1, 24, 2, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2449BA156C6E55B5` (`nom`),
  ADD KEY `IDX_2449BA15F510AAE9` (`pilote_id`);

--
-- Index pour la table `ihni_user`
--
ALTER TABLE `ihni_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F721A03A92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_F721A03AA0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_F721A03AC05FB297` (`confirmation_token`),
  ADD KEY `IDX_F721A03AB03A8386` (`created_by_id`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C2426286C6E55B5` (`nom`),
  ADD UNIQUE KEY `UNIQ_C242628F47645AE` (`url`),
  ADD UNIQUE KEY `UNIQ_C242628C912ED9D` (`api_key`);

--
-- Index pour la table `module_equipe`
--
ALTER TABLE `module_equipe`
  ADD PRIMARY KEY (`module_id`,`equipe_id`),
  ADD KEY `IDX_8E4AFA3AAFC2B591` (`module_id`),
  ADD KEY `IDX_8E4AFA3A6D861B89` (`equipe_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `team_role`
--
ALTER TABLE `team_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_86887E11D60322AC` (`role_id`),
  ADD KEY `IDX_86887E11A76ED395` (`user_id`),
  ADD KEY `IDX_86887E116D861B89` (`equipe_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `ihni_user`
--
ALTER TABLE `ihni_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `team_role`
--
ALTER TABLE `team_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `FK_2449BA15F510AAE9` FOREIGN KEY (`pilote_id`) REFERENCES `ihni_user` (`id`);

--
-- Contraintes pour la table `ihni_user`
--
ALTER TABLE `ihni_user`
  ADD CONSTRAINT `FK_F721A03AB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `ihni_user` (`id`);

--
-- Contraintes pour la table `module_equipe`
--
ALTER TABLE `module_equipe`
  ADD CONSTRAINT `FK_8E4AFA3A6D861B89` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8E4AFA3AAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `team_role`
--
ALTER TABLE `team_role`
  ADD CONSTRAINT `FK_86887E116D861B89` FOREIGN KEY (`equipe_id`) REFERENCES `equipe` (`id`),
  ADD CONSTRAINT `FK_86887E11A76ED395` FOREIGN KEY (`user_id`) REFERENCES `ihni_user` (`id`),
  ADD CONSTRAINT `FK_86887E11D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
