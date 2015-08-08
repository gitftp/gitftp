-- --------------------------------------------------------
-- Host:                         console.gitftp.com
-- Server version:               5.5.44-0ubuntu0.14.04.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for craftrzt_gitftp
DROP DATABASE IF EXISTS `craftrzt_gitftp`;
CREATE DATABASE IF NOT EXISTS `craftrzt_gitftp` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `craftrzt_gitftp`;


-- Dumping structure for table craftrzt_gitftp.branches
DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deploy_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '(unnamed)',
  `branch_name` varchar(50) NOT NULL DEFAULT 'master',
  `auto` int(11) NOT NULL DEFAULT '0',
  `ftp_id` int(11) NOT NULL,
  `ready` int(11) NOT NULL DEFAULT '0',
  `skip_path` longtext,
  `purge_path` longtext,
  `revision` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `repo` (`deploy_id`),
  CONSTRAINT `repo` FOREIGN KEY (`deploy_id`) REFERENCES `deploy` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitftp.branches: ~0 rows (approximately)
DELETE FROM `branches`;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.deploy
DROP TABLE IF EXISTS `deploy`;
CREATE TABLE IF NOT EXISTS `deploy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `repository` varchar(500) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `gitname` varchar(50) DEFAULT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `key` varchar(150) NOT NULL,
  `cloned` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_deploy_users` (`user_id`),
  CONSTRAINT `FK_deploy_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitftp.deploy: ~0 rows (approximately)
DELETE FROM `deploy`;
/*!40000 ALTER TABLE `deploy` DISABLE KEYS */;
/*!40000 ALTER TABLE `deploy` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.ftp
DROP TABLE IF EXISTS `ftp`;
CREATE TABLE IF NOT EXISTS `ftp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `username` varchar(150) NOT NULL DEFAULT '0',
  `port` int(11) NOT NULL,
  `scheme` varchar(50) NOT NULL,
  `path` varchar(50) NOT NULL,
  `host` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pass` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_ftp_users` (`user_id`),
  CONSTRAINT `FK_ftp_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitftp.ftp: ~0 rows (approximately)
DELETE FROM `ftp`;
/*!40000 ALTER TABLE `ftp` DISABLE KEYS */;
/*!40000 ALTER TABLE `ftp` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.log
DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitftp.log: ~0 rows (approximately)
DELETE FROM `log`;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.messages
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  `type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitftp.messages: ~0 rows (approximately)
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.migration
DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `type` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `migration` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitftp.migration: ~10 rows (approximately)
DELETE FROM `migration`;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '001_auth_create_usertables');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '002_auth_create_grouptables');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '003_auth_create_roletables');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '004_auth_create_permissiontables');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '005_auth_create_authdefaults');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '006_auth_add_authactions');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '007_auth_add_permissionsfilter');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '008_auth_create_providers');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '009_auth_create_oauth2tables');
INSERT INTO `migration` (`type`, `name`, `migration`) VALUES
	('package', 'auth', '010_auth_fix_jointables');
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.records
DROP TABLE IF EXISTS `records`;
CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deploy_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `record_type` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `amount_deployed_raw` int(11) NOT NULL,
  `amount_deployed` varchar(50) NOT NULL DEFAULT '0 B',
  `raw` longtext NOT NULL,
  `date` int(11) NOT NULL,
  `triggerby` varchar(150) NOT NULL DEFAULT 'System',
  `post_data` longtext,
  `avatar_url` text,
  `hash_before` text,
  `hash` text,
  `commits` text,
  `file_add` int(11) NOT NULL DEFAULT '0',
  `file_remove` int(11) NOT NULL DEFAULT '0',
  `file_skip` int(11) NOT NULL DEFAULT '0',
  `file_purge` int(11) NOT NULL DEFAULT '0',
  `total_files` int(11) NOT NULL DEFAULT '0',
  `processed_files` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `deploy_record` (`deploy_id`),
  CONSTRAINT `deploy_record` FOREIGN KEY (`deploy_id`) REFERENCES `deploy` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitftp.records: ~0 rows (approximately)
DELETE FROM `records`;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
/*!40000 ALTER TABLE `records` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT '0',
  `password` varchar(50) DEFAULT '0',
  `group` int(11) DEFAULT '0',
  `email` varchar(50) DEFAULT '0',
  `last_login` varchar(50) DEFAULT '0',
  `login_hash` varchar(50) DEFAULT '0',
  `profile_fields` text,
  `created_at` int(11) DEFAULT '0',
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitftp.users: ~1 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `group`, `email`, `last_login`, `login_hash`, `profile_fields`, `created_at`, `updated_at`) VALUES
	(228, 'boniface', 'yxWaVWNE2FmQ15CZYdPeOnJR3bwnvptHY6xztiJYU90=', 2, 'bonifacepereira@gmail.com', '1439037351', '708442a35570b1dca2dcd238283848893853e886', 'a:4:{s:8:"fullname";s:16:"Boniface pereira";s:3:"hey";s:3:"asd";s:8:"verified";b:1;s:6:"github";s:8:"craftpip";}', 1427962033, 1439037363);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.users_clients
DROP TABLE IF EXISTS `users_clients`;
CREATE TABLE IF NOT EXISTS `users_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `client_secret` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(255) NOT NULL DEFAULT '',
  `auto_approve` tinyint(1) NOT NULL DEFAULT '0',
  `autonomous` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('development','pending','approved','rejected') NOT NULL DEFAULT 'development',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `notes` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitftp.users_clients: ~0 rows (approximately)
DELETE FROM `users_clients`;
/*!40000 ALTER TABLE `users_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_clients` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.users_providers
DROP TABLE IF EXISTS `users_providers`;
CREATE TABLE IF NOT EXISTS `users_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `provider` varchar(50) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `expires` int(12) DEFAULT '0',
  `refresh_token` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitftp.users_providers: ~0 rows (approximately)
DELETE FROM `users_providers`;
/*!40000 ALTER TABLE `users_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_providers` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.users_scopes
DROP TABLE IF EXISTS `users_scopes`;
CREATE TABLE IF NOT EXISTS `users_scopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scope` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `scope` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitftp.users_scopes: ~0 rows (approximately)
DELETE FROM `users_scopes`;
/*!40000 ALTER TABLE `users_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_scopes` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.users_sessions
DROP TABLE IF EXISTS `users_sessions`;
CREATE TABLE IF NOT EXISTS `users_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(32) NOT NULL DEFAULT '',
  `redirect_uri` varchar(255) NOT NULL DEFAULT '',
  `type_id` varchar(64) NOT NULL,
  `type` enum('user','auto') NOT NULL DEFAULT 'user',
  `code` text NOT NULL,
  `access_token` varchar(50) NOT NULL DEFAULT '',
  `stage` enum('request','granted') NOT NULL DEFAULT 'request',
  `first_requested` int(11) NOT NULL,
  `last_updated` int(11) NOT NULL,
  `limited_access` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `oauth_sessions_ibfk_1` (`client_id`),
  CONSTRAINT `oauth_sessions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users_clients` (`client_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitftp.users_sessions: ~0 rows (approximately)
DELETE FROM `users_sessions`;
/*!40000 ALTER TABLE `users_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_sessions` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitftp.users_sessionscopes
DROP TABLE IF EXISTS `users_sessionscopes`;
CREATE TABLE IF NOT EXISTS `users_sessionscopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `access_token` varchar(50) NOT NULL DEFAULT '',
  `scope` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  KEY `access_token` (`access_token`),
  KEY `scope` (`scope`),
  CONSTRAINT `oauth_sessionscopes_ibfk_1` FOREIGN KEY (`scope`) REFERENCES `users_scopes` (`scope`),
  CONSTRAINT `oauth_sessionscopes_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `users_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitftp.users_sessionscopes: ~0 rows (approximately)
DELETE FROM `users_sessionscopes`;
/*!40000 ALTER TABLE `users_sessionscopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_sessionscopes` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
