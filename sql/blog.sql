-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 28 déc. 2021 à 13:00
-- Version du serveur : 8.0.27
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author` int NOT NULL,
  `post_id` int NOT NULL,
  `content` longtext NOT NULL,
  `last_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_moderate` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_comment_user1_idx` (`author`),
  KEY `fk_comment_post1_idx` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `author`, `post_id`, `content`, `last_update`, `is_moderate`) VALUES
(1, 1, 1, 'My first comment', '2021-12-16 15:57:15', 1),
(2, 4, 1, 'Second comment not moderated', '2021-12-28 13:47:55', 0);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author` int NOT NULL,
  `title` varchar(70) NOT NULL,
  `photo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'orion-nebula-11107_1920.jpg',
  `chapo` varchar(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` longtext NOT NULL,
  `last_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_post_user_idx` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `author`, `title`, `photo`, `chapo`, `content`, `last_update`) VALUES
(1, 1, 'Premier article', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce malesuada elit sed odio ullamcorper posuere eget sit amet tellus. Phasellus dignissim risus eget felis posuere blandit. Suspendisse facilisis euismod sagittis. \n\nProin convallis velit elit, a tempor sapien blandit at. Nam pretium nibh libero, non vehicula augue egestas vel. Sed luctus lectus et justo rutrum ultricies. Mauris mollis id odio eget iaculis. Donec velit odio, sodales sit amet semper vitae, semper in tellus. Nam arcu nulla, placerat vitae velit sit amet, cursus euismod eros. Quisque sit amet mi eu nunc consequat tincid', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce malesuada elit sed odio ullamcorper posuere eget sit amet tellus. Phasellus dignissim risus eget felis posuere blandit.Suspendisse facilisis euismod sagittis. \r\n\r\nProin convallis velit elit, a tempor sapien blandit at. Nam pretium nibh libero, non vehicula augue egestas vel. Sed luctus lectus et justo rutrum ultricies. Mauris mollis id odio eget iaculis. Donec velit odio, sodales sit amet semper vitae, semper in tellus. Nam arcu nulla, placerat vitae velit sit amet, cursus euismod eros. Quisque sit amet mi eu nunc consequat tincidunt.Lorem ipsum dolor sit amet, consectetur adipiscing elit. \r\n\r\nFusce malesuada elit sed odio ullamcorper posuere eget sit amet tellus. Phasellus dignissim risus eget felis posuere blandit. Suspendisse facilisis euismod sagittis. Proin convallis velit elit, a tempor sapien blandit at. Nam pretium nibh libero, non vehicula augue egestas vel. Sed luctus lectus et justo rutrum ultricies. Mauris mollis id odio eget iaculis. Donec velit odio, sodales sit amet semper vitae, semper in tellus. Nam arcu nulla, placerat vitae velit sit amet, cursus euismod eros. Quisque sit amet mi eu nunc consequat tincidunt.', '2021-12-28 13:59:15'),
(2, 1, 'Second article', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', '2021-12-28 13:44:33'),
(3, 4, 'Troisième article', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', '2021-12-28 13:44:39'),
(4, 1, 'Programmation Orientée Objet  - PHP', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam, officia illo earum vitae alias dolorum nemo impedit cupiditate ipsa totam eaque aliquam quidem tempora cum dolores aspernatur consequuntur accusamus voluptatem. Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam, officia illo earum vitae alias dolorum nemo impedit cupiditate ipsa totam eaque aliquam quidem tempora cum dolores aspernatur consequuntur accusamus voluptatem.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam, officia illo earum vitae alias dolorum nemo impedit cupiditate ipsa totam eaque aliquam quidem tempora cum dolores aspernatur consequuntur accusamus voluptatem.\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam, officia illo earum vitae alias dolorum nemo impedit cupiditate ipsa totam eaque aliquam quidem tempora cum dolores aspernatur consequuntur accusamus voluptatem.', '2021-12-28 13:45:12'),
(5, 1, 'Nouvel article', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce malesuada elit sed odio ullamcorper posuere eget sit amet tellus. Phasellus dignissim risus eget felis posuere blandit. Suspendisse facilisis euismod sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce malesuada elit sed odio ullamcorper posuere eget sit amet tellus. Phasellus dignissim risus eget felis posuere blandit. Suspendisse facilisis euismod sagittis. \r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce malesuada elit sed odio ullamcorper posuere eget sit amet tellus. Phasellus dignissim risus eget felis posuere blandit. Suspendisse facilisis euismod sagittis. \r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce malesuada elit sed odio ullamcorper posuere eget sit amet tellus. Phasellus dignissim risus eget felis posuere blandit. Suspendisse facilisis euismod sagittis.', '2021-12-28 13:59:19');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(70) NOT NULL,
  `last_name` varchar(70) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_validate` tinyint NOT NULL DEFAULT '0',
  `is_admin` tinyint NOT NULL DEFAULT '0',
  `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `is_validate`, `is_admin`, `registration_date`) VALUES
(1, 'Jonathan', 'Secher', 'jonathan.secher@email.com', '$2y$09$YMuboA6w3mp1y5qmuFTeueFnh20aW2pYQbp7NTUrdSqLPPFg2IKSC', 1, 1, '2021-12-08 22:46:38'),
(2, 'Melvin', 'Konrad', 'melvin.konrad@email.com', '$2y$09$YMuboA6w3mp1y5qmuFTeueFnh20aW2pYQbp7NTUrdSqLPPFg2IKSC', 1, 1, '2021-12-15 23:57:54'),
(3, 'Laura', 'Durand', 'laura.durand@email.com', '$2y$09$YMuboA6w3mp1y5qmuFTeueFnh20aW2pYQbp7NTUrdSqLPPFg2IKSC', 1, 1, '2021-12-10 02:38:20'),
(4, 'John', 'Doe', 'john.doe@email.com', '$2y$09$YMuboA6w3mp1y5qmuFTeueFnh20aW2pYQbp7NTUrdSqLPPFg2IKSC', 1, 0, '2021-12-08 22:47:32');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comment_user1` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
