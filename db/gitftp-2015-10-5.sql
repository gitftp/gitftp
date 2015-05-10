-- --------------------------------------------------------
-- Host:                         192.168.1.5
-- Server version:               5.5.41-0ubuntu0.14.10.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for craftrzt_gitploy
DROP DATABASE IF EXISTS `craftrzt_gitploy`;
CREATE DATABASE IF NOT EXISTS `craftrzt_gitploy` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `craftrzt_gitploy`;


-- Dumping structure for table craftrzt_gitploy.branches
DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL DEFAULT 'master',
  `auto` int(11) NOT NULL DEFAULT '0',
  `ftp_id` int(11) NOT NULL,
  `ready` int(11) NOT NULL DEFAULT '0',
  `skip_path` text,
  `purge_path` text,
  `revision` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `repo` (`repo_id`),
  CONSTRAINT `repo` FOREIGN KEY (`repo_id`) REFERENCES `deploy` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.branches: ~0 rows (approximately)
DELETE FROM `branches`;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.deploy
DROP TABLE IF EXISTS `deploy`;
CREATE TABLE IF NOT EXISTS `deploy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository` varchar(500) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `key` varchar(150) NOT NULL,
  `cloned` varchar(150) NOT NULL,
  `deployed` varchar(150) NOT NULL,
  `lastdeploy` varchar(150) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `ready` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_deploy_users` (`user_id`),
  CONSTRAINT `FK_deploy_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.deploy: ~0 rows (approximately)
DELETE FROM `deploy`;
/*!40000 ALTER TABLE `deploy` DISABLE KEYS */;
/*!40000 ALTER TABLE `deploy` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.ftpdata
DROP TABLE IF EXISTS `ftpdata`;
CREATE TABLE IF NOT EXISTS `ftpdata` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.ftpdata: ~3 rows (approximately)
DELETE FROM `ftpdata`;
/*!40000 ALTER TABLE `ftpdata` DISABLE KEYS */;
INSERT INTO `ftpdata` (`id`, `name`, `username`, `port`, `scheme`, `path`, `host`, `user_id`, `pass`, `created_at`) VALUES
	(106, 'test_test1', 'craftrzt', 21, 'ftps', '/test/test1', 'craftpip.com', 228, '6?1Hj8I9k8a3', '2015-04-26 15:51:16'),
	(130, 'test2', 'craftrzt', 21, 'ftps', '/test/test3', 'craftpip.com', 228, '6?1Hj8I9k8a3', '2015-04-23 01:06:35'),
	(131, '', 'craftrzt', 21, 'ftps', '/test/test2', 'craftpip.com', 228, '6?1Hj8I9k8a3', '2015-04-14 23:26:37');
/*!40000 ALTER TABLE `ftpdata` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.records
DROP TABLE IF EXISTS `records`;
CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deploy_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `status` varchar(50) NOT NULL DEFAULT 'false',
  `branch_id` int(11) NOT NULL,
  `amount_deployed_raw` varchar(50) NOT NULL DEFAULT 'false',
  `amount_deployed` varchar(50) NOT NULL DEFAULT '0 B',
  `raw` longtext NOT NULL,
  `date` int(11) NOT NULL,
  `triggerby` varchar(150) NOT NULL DEFAULT 'System',
  `post_data` longtext,
  `avatar_url` text,
  `hash` text,
  `commit_count` text,
  `commit_message` text,
  `file_add` varchar(50) DEFAULT '0',
  `file_remove` varchar(50) DEFAULT '0',
  `file_skip` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `deploy_record` (`deploy_id`),
  CONSTRAINT `deploy_record` FOREIGN KEY (`deploy_id`) REFERENCES `deploy` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.records: ~0 rows (approximately)
DELETE FROM `records`;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
/*!40000 ALTER TABLE `records` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT '0',
  `password` varchar(50) DEFAULT '0',
  `group` int(11) DEFAULT '0',
  `email` varchar(50) DEFAULT '0',
  `mobileno` varchar(15) DEFAULT '0',
  `address` varchar(150) DEFAULT '0',
  `last_login` varchar(50) DEFAULT '0',
  `login_hash` varchar(50) DEFAULT '0',
  `profile_fields` text,
  `created_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.users: ~3 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `group`, `email`, `mobileno`, `address`, `last_login`, `login_hash`, `profile_fields`, `created_at`) VALUES
	(228, 'boniface', 'Moympi2IA2w/zrNxrJvDoK/DULtt0hvpHDdl/14dyeo=', 1, 'bonifacepereira@gmail.com', '0', '0', '1430581692', '8858274614275e75e6c6ecd3244a6815c3c571e3', 'a:1:{s:8:"fullname";s:16:"Boniface pereira";}', 1427962033),
	(229, 'boniface2', 'Moympi2IA2w/zrNxrJvDoK/DULtt0hvpHDdl/14dyeo=', 1, 'boniface2@gmail.com', '0', '0', '1429643670', 'f90237a8b014f44fb964ec9dca6f6c4615f05ca0', 'a:3:{s:8:"fullname";s:16:"boniface pereira";s:10:"repo_limit";i:2;s:8:"verified";i:0;}', 1429643651),
	(230, 'gaurish', '/cSinYvvkRCiJ92IlcWR69PvRT3P7CjWe7xNpisl2Iw=', 1, 'megaurishrane@gmail.com', '0', '0', '0', '', 'a:3:{s:8:"fullname";s:12:"Gaurish rane";s:10:"repo_limit";i:2;s:8:"verified";i:0;}', 1429728790);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
