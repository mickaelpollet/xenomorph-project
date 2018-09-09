-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.18 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.5.0.5284
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour octopus
CREATE DATABASE IF NOT EXISTS `octopus` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `octopus`;

-- Listage de la structure de la table octopus. rights
CREATE TABLE IF NOT EXISTS `rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `x_rights_id_ref` int(11) NOT NULL,
  `rights_level` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rights_lvl` (`rights_level`),
  KEY `X_Rights_XRights` (`x_rights_id_ref`),
  CONSTRAINT `X_Rights_XRights` FOREIGN KEY (`x_rights_id_ref`) REFERENCES `x_rights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. users_informations
CREATE TABLE IF NOT EXISTS `users_informations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xuser_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `UserInfos_XUsers` (`xuser_id`),
  CONSTRAINT `UserInfos_XUsers` FOREIGN KEY (`xuser_id`) REFERENCES `x_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_logs
CREATE TABLE IF NOT EXISTS `x_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(15) NOT NULL,
  `type` int(5) NOT NULL,
  `criticity` int(5) NOT NULL DEFAULT '1',
  `code` varchar(50) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `log_line` int(255) DEFAULT NULL,
  `parameters` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `criticity` (`criticity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_menus
CREATE TABLE IF NOT EXISTS `x_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `link` tinyint(4) DEFAULT NULL,
  `visible` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_XMenus_XMenus_parent_id` (`parent_id`),
  CONSTRAINT `FK_XMenus_XMenus_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `x_menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_permissions
CREATE TABLE IF NOT EXISTS `x_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 = min, 2 = max, 3 =equal',
  PRIMARY KEY (`id`),
  KEY `FK_XPermissions_XPermissionsType` (`category`),
  CONSTRAINT `FK_XPermissions_XPermissionsType` FOREIGN KEY (`category`) REFERENCES `x_permissions_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_permissions_categories
CREATE TABLE IF NOT EXISTS `x_permissions_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_rights
CREATE TABLE IF NOT EXISTS `x_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rights_level` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rights_level` (`rights_level`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_sso_applications
CREATE TABLE IF NOT EXISTS `x_sso_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `app_key` varchar(255) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_sso_connection` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_sso_links
CREATE TABLE IF NOT EXISTS `x_sso_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_users
CREATE TABLE IF NOT EXISTS `x_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) NOT NULL,
  `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_users_informations
CREATE TABLE IF NOT EXISTS `x_users_informations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `lang` char(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `X_UsersInfos_Users` (`id_user`),
  CONSTRAINT `X_UsersInfos_Users` FOREIGN KEY (`id_user`) REFERENCES `x_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_users_rights
CREATE TABLE IF NOT EXISTS `x_users_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_rights` int(11) NOT NULL DEFAULT '1' COMMENT 'Niveau de droits des utilisateurs',
  `id_sub_rights` int(11) DEFAULT NULL COMMENT 'Niveau de droits applicatif',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_user` (`id_user`),
  KEY `X_UsersRights_XRights` (`id_rights`),
  KEY `X_UsersRights_Rights` (`id_sub_rights`),
  CONSTRAINT `X_UsersRights_Rights` FOREIGN KEY (`id_sub_rights`) REFERENCES `rights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `X_UsersRights_Users` FOREIGN KEY (`id_user`) REFERENCES `x_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `X_UsersRights_XRights` FOREIGN KEY (`id_rights`) REFERENCES `x_rights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_users_security
CREATE TABLE IF NOT EXISTS `x_users_security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `otp` int(1) NOT NULL DEFAULT '0' COMMENT '0 : Pas d''OTP, 1 : OTP Mail, 2 : OTP SMS',
  `certificate` longtext,
  PRIMARY KEY (`id`),
  KEY `X_UsersSecurity_Users` (`id_user`),
  CONSTRAINT `X_UsersSecurity_Users` FOREIGN KEY (`id_user`) REFERENCES `x_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table octopus. x_users_sessions
CREATE TABLE IF NOT EXISTS `x_users_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `token` longtext NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `logging_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  KEY `X_UsersSessions_XUsers` (`id_user`),
  CONSTRAINT `X_UsersSessions_XUsers` FOREIGN KEY (`id_user`) REFERENCES `x_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
