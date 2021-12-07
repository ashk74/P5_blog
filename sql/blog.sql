-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 déc. 2021 à 01:51
-- Version du serveur : 8.0.27
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";


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
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_moderate` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_comment_user1_idx` (`author`),
  KEY `fk_comment_post1_idx` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author` int NOT NULL,
  `title` varchar(70) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `chapo` varchar(300) NOT NULL,
  `content` longtext NOT NULL,
  `link` varchar(2048) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_post_user_idx` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `author`, `title`, `photo`, `chapo`, `content`, `link`, `last_update`) VALUES
(1, 1, 'Premier article', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', '', '2021-12-07 01:15:30'),
(2, 1, 'Second article', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', '', '2021-12-07 01:16:02'),
(3, 1, 'Troisième article', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', '', '2021-12-07 01:16:33'),
(4, 1, 'Quatrième article', 'orion-nebula-11107_1920.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum! Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, commodi. Iste sint amet explicabo. Dolorum perferendis odit in totam, non, quod ipsa assumenda consequuntur excepturi tempora ducimus repellendus laudantium rerum!', '', '2021-12-07 01:17:04');

-- --------------------------------------------------------

--
-- Structure de la table `post_tag`
--

DROP TABLE IF EXISTS `post_tag`;
CREATE TABLE IF NOT EXISTS `post_tag` (
  `post_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `fk_tag_has_post_post1_idx` (`post_id`),
  KEY `fk_tag_has_post_tag1_idx` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `post_tag`
--

INSERT INTO `post_tag` (`post_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 4),
(3, 1),
(3, 3),
(4, 2),
(4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'PHP'),
(2, 'MySQL'),
(3, 'HTML/CSS'),
(4, 'JS');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `photo` varchar(200) NOT NULL,
  `first_name` varchar(70) NOT NULL,
  `last_name` varchar(70) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_validate` tinyint NOT NULL DEFAULT '0',
  `is_admin` tinyint NOT NULL DEFAULT '0',
  `token` varchar(32) NOT NULL,
  `token_expiration` timestamp NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_adress` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `photo`, `first_name`, `last_name`, `email`, `password`, `is_validate`, `is_admin`, `token`, `token_expiration`, `registration_date`, `ip_adress`) VALUES
(1, 'avatar-1.png', 'Jonathan', 'Secher', 'jonathan.secher@email.com', 'azerty', 1, 1, '15825b2766c77380bd836e06123d10fc', '2021-11-01 09:10:42', '2021-12-06 22:13:19', '');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `fk_comment_user1` FOREIGN KEY (`author`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`author`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `fk_tag_has_post_post1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `fk_tag_has_post_tag1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
