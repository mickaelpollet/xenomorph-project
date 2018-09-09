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

-- Listage des données de la table octopus.rights : ~0 rows (environ)
/*!40000 ALTER TABLE `rights` DISABLE KEYS */;
/*!40000 ALTER TABLE `rights` ENABLE KEYS */;

-- Listage de la structure de la table octopus. users_informations
CREATE TABLE IF NOT EXISTS `users_informations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xuser_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `UserInfos_XUsers` (`xuser_id`),
  CONSTRAINT `UserInfos_XUsers` FOREIGN KEY (`xuser_id`) REFERENCES `x_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- Listage des données de la table octopus.users_informations : ~1 rows (environ)
/*!40000 ALTER TABLE `users_informations` DISABLE KEYS */;
REPLACE INTO `users_informations` (`id`, `xuser_id`) VALUES
	(5, 27);
/*!40000 ALTER TABLE `users_informations` ENABLE KEYS */;

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

-- Listage des données de la table octopus.x_logs : ~0 rows (environ)
/*!40000 ALTER TABLE `x_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `x_logs` ENABLE KEYS */;

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

-- Listage des données de la table octopus.x_menus : ~5 rows (environ)
/*!40000 ALTER TABLE `x_menus` DISABLE KEYS */;
REPLACE INTO `x_menus` (`id`, `parent_id`, `name`, `controller`, `icon`, `color`, `link`, `visible`) VALUES
	(1, NULL, 'users', 'users', 'group', NULL, 1, 1),
	(2, NULL, 'supervision', 'supervision', 'database-search', NULL, 1, 1),
	(3, NULL, 'sandbox', 'sandbox', 'lab', NULL, 1, 1),
	(6, NULL, 'sso', 'sso', 'random', NULL, 1, 1),
	(7, NULL, 'administration', 'administration', 'wrench', NULL, 1, 1);
/*!40000 ALTER TABLE `x_menus` ENABLE KEYS */;

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

-- Listage des données de la table octopus.x_permissions : ~7 rows (environ)
/*!40000 ALTER TABLE `x_permissions` DISABLE KEYS */;
REPLACE INTO `x_permissions` (`id`, `category`, `category_id`, `level`, `type`) VALUES
	(4, 1, 1, 70, 1),
	(5, 1, 2, 90, 1),
	(6, 1, 3, 90, 1),
	(7, 1, 4, 70, 1),
	(8, 1, 5, 40, 1),
	(9, 1, 6, 100, 1),
	(10, 1, 7, 70, 1);
/*!40000 ALTER TABLE `x_permissions` ENABLE KEYS */;

-- Listage de la structure de la table octopus. x_permissions_categories
CREATE TABLE IF NOT EXISTS `x_permissions_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Listage des données de la table octopus.x_permissions_categories : ~2 rows (environ)
/*!40000 ALTER TABLE `x_permissions_categories` DISABLE KEYS */;
REPLACE INTO `x_permissions_categories` (`id`, `name`) VALUES
	(1, 'menu'),
	(2, 'controller');
/*!40000 ALTER TABLE `x_permissions_categories` ENABLE KEYS */;

-- Listage de la structure de la table octopus. x_rights
CREATE TABLE IF NOT EXISTS `x_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rights_level` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rights_level` (`rights_level`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Listage des données de la table octopus.x_rights : ~11 rows (environ)
/*!40000 ALTER TABLE `x_rights` DISABLE KEYS */;
REPLACE INTO `x_rights` (`id`, `rights_level`, `libelle`) VALUES
	(1, 1, 'Désactivé'),
	(2, 10, 'A valider'),
	(3, 20, 'Préinscrit'),
	(4, 30, 'Mot de passe à changer'),
	(5, 40, 'Validé'),
	(6, 50, 'Manager'),
	(7, 60, 'Compte applicatif'),
	(8, 70, 'Administrateur'),
	(9, 80, 'Administrateur applicatif'),
	(10, 90, 'Administrateur développeur'),
	(11, 100, 'Super Administrateur');
/*!40000 ALTER TABLE `x_rights` ENABLE KEYS */;

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

-- Listage des données de la table octopus.x_sso_applications : ~0 rows (environ)
/*!40000 ALTER TABLE `x_sso_applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `x_sso_applications` ENABLE KEYS */;

-- Listage de la structure de la table octopus. x_sso_links
CREATE TABLE IF NOT EXISTS `x_sso_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table octopus.x_sso_links : ~0 rows (environ)
/*!40000 ALTER TABLE `x_sso_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `x_sso_links` ENABLE KEYS */;

-- Listage de la structure de la table octopus. x_users
CREATE TABLE IF NOT EXISTS `x_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) NOT NULL,
  `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

-- Listage des données de la table octopus.x_users : ~1 rows (environ)
/*!40000 ALTER TABLE `x_users` DISABLE KEYS */;
REPLACE INTO `x_users` (`id`, `mail`, `creationDate`) VALUES
	(27, 'pollet.m@mipih.fr', '2016-08-11 10:28:25');
/*!40000 ALTER TABLE `x_users` ENABLE KEYS */;

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

-- Listage des données de la table octopus.x_users_informations : ~1 rows (environ)
/*!40000 ALTER TABLE `x_users_informations` DISABLE KEYS */;
REPLACE INTO `x_users_informations` (`id`, `id_user`, `fname`, `lname`, `lang`) VALUES
	(19, 27, 'Mickaël', 'POLLET', 'fr');
/*!40000 ALTER TABLE `x_users_informations` ENABLE KEYS */;

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

-- Listage des données de la table octopus.x_users_rights : ~1 rows (environ)
/*!40000 ALTER TABLE `x_users_rights` DISABLE KEYS */;
REPLACE INTO `x_users_rights` (`id`, `id_user`, `id_rights`, `id_sub_rights`) VALUES
	(15, 27, 11, NULL);
/*!40000 ALTER TABLE `x_users_rights` ENABLE KEYS */;

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

-- Listage des données de la table octopus.x_users_security : ~1 rows (environ)
/*!40000 ALTER TABLE `x_users_security` DISABLE KEYS */;
REPLACE INTO `x_users_security` (`id`, `id_user`, `password`, `otp`, `certificate`) VALUES
	(19, 27, '1719f30db2ae7e1e71949b75317cc101566d44ea70265647f67f9ef6481aec33e192764836d5dafef7d856509848eb6190581a129ab3afd28c49aaf55d6fb4de', 0, '');
/*!40000 ALTER TABLE `x_users_security` ENABLE KEYS */;

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

-- Listage des données de la table octopus.x_users_sessions : ~0 rows (environ)
/*!40000 ALTER TABLE `x_users_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `x_users_sessions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
