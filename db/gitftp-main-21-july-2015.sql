-- --------------------------------------------------------
-- Host:                         stg.gitftp.com
-- Server version:               5.5.43-0ubuntu0.14.10.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.2.0.4947
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
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.branches: ~1 rows (approximately)
DELETE FROM `branches`;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` (`id`, `deploy_id`, `user_id`, `name`, `branch_name`, `auto`, `ftp_id`, `ready`, `skip_path`, `purge_path`, `revision`) VALUES
	(93, 47, 228, 'asdsadsadsadsadsada asd sadas da', 'master', 0, 131, 1, 'a:0:{}', 'a:0:{}', '21d73f300175c5673082ea1a05891517d7603729');
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
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_deploy_users` (`user_id`),
  CONSTRAINT `FK_deploy_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.deploy: ~1 rows (approximately)
DELETE FROM `deploy`;
/*!40000 ALTER TABLE `deploy` DISABLE KEYS */;
INSERT INTO `deploy` (`id`, `repository`, `active`, `name`, `user_id`, `username`, `password`, `key`, `cloned`, `created_at`) VALUES
	(47, 'https://github.com/craftpip/testrepo.git', 0, 'asdasda esfsfasdasd', 228, '', '', 'rwefrwqexqrderewrfwer', '1', '2015-07-19 17:33:23');
/*!40000 ALTER TABLE `deploy` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.ftp
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
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.ftp: ~3 rows (approximately)
DELETE FROM `ftp`;
/*!40000 ALTER TABLE `ftp` DISABLE KEYS */;
INSERT INTO `ftp` (`id`, `name`, `username`, `port`, `scheme`, `path`, `host`, `user_id`, `pass`, `created_at`) VALUES
	(131, 'test2 - asd a- sa-d as-d sa-dsa- dsadsadsa', 'test@craftpip.com', 21, 'ftps', '/test2', 'craftpip.com', 228, 'testtest', '2015-07-16 21:07:10');
INSERT INTO `ftp` (`id`, `name`, `username`, `port`, `scheme`, `path`, `host`, `user_id`, `pass`, `created_at`) VALUES
	(132, 'test1', 'test@craftpip.com', 21, 'ftps', '/test2', 'craftpip.com', 228, 'testtest', '2015-07-15 23:56:54');
INSERT INTO `ftp` (`id`, `name`, `username`, `port`, `scheme`, `path`, `host`, `user_id`, `pass`, `created_at`) VALUES
	(135, 'ownpc', 'r', 21, 'ftp', '/', '192.168.1.12', 228, 'r', '2015-07-15 23:49:25');
/*!40000 ALTER TABLE `ftp` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.log
DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=299 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.log: ~28 rows (approximately)
DELETE FROM `log`;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` (`id`, `a`) VALUES
	(277, 'a:1:{i:0;s:50:"Your branch is up-to-date with \'origin/something\'.";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(278, 'asda');
INSERT INTO `log` (`id`, `a`) VALUES
	(279, 'a:1:{i:0;s:50:"Your branch is up-to-date with \'origin/something\'.";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(280, 'a:4:{i:0;s:15:"Fetching origin";i:1;s:19:"Already up-to-date.";i:2;s:15:"Fetching origin";i:3;s:28:"HEAD is now at 98a7fca asdas";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(281, 'a:1:{i:0;s:50:"Your branch is up-to-date with \'origin/something\'.";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(282, 'a:4:{i:0;s:15:"Fetching origin";i:1;s:19:"Already up-to-date.";i:2;s:15:"Fetching origin";i:3;s:28:"HEAD is now at 98a7fca asdas";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(283, 'a:1:{i:0;s:50:"Your branch is up-to-date with \'origin/something\'.";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(284, 'a:4:{i:0;s:15:"Fetching origin";i:1;s:19:"Already up-to-date.";i:2;s:15:"Fetching origin";i:3;s:28:"HEAD is now at 98a7fca asdas";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(285, 'a:1:{i:0;s:50:"Your branch is up-to-date with \'origin/something\'.";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(286, 'a:4:{i:0;s:15:"Fetching origin";i:1;s:19:"Already up-to-date.";i:2;s:15:"Fetching origin";i:3;s:28:"HEAD is now at 98a7fca asdas";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(287, '{"ref":"refs/heads/master","before":"e3100afa464290a6f28215f74a960269925a6cc6","after":"7cfe41f8e38e42691823517bab72658d392db19a","created":false,"deleted":false,"forced":false,"base_ref":null,"compare":"https://github.com/craftpip/testrepo/compare/e3100afa4642...7cfe41f8e38e","commits":[{"id":"7cfe41f8e38e42691823517bab72658d392db19a","distinct":true,"message":"asdsa","timestamp":"2015-07-15T23:08:20+05:30","url":"https://github.com/craftpip/testrepo/commit/7cfe41f8e38e42691823517bab72658d392db19a","author":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"committer":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"added":[],"removed":["New File3.txt"],"modified":[]}],"head_commit":{"id":"7cfe41f8e38e42691823517bab72658d392db19a","distinct":true,"message":"asdsa","timestamp":"2015-07-15T23:08:20+05:30","url":"https://github.com/craftpip/testrepo/commit/7cfe41f8e38e42691823517bab72658d392db19a","author":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"committer":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"added":[],"removed":["New File3.txt"],"modified":[]},"repository":{"id":33416050,"name":"testrepo","full_name":"craftpip/testrepo","owner":{"name":"craftpip","email":"bonifacepereira@gmail.com"},"private":false,"html_url":"https://github.com/craftpip/testrepo","description":"my git playground.","fork":false,"url":"https://github.com/craftpip/testrepo","forks_url":"https://api.github.com/repos/craftpip/testrepo/forks","keys_url":"https://api.github.com/repos/craftpip/testrepo/keys{/key_id}","collaborators_url":"https://api.github.com/repos/craftpip/testrepo/collaborators{/collaborator}","teams_url":"https://api.github.com/repos/craftpip/testrepo/teams","hooks_url":"https://api.github.com/repos/craftpip/testrepo/hooks","issue_events_url":"https://api.github.com/repos/craftpip/testrepo/issues/events{/number}","events_url":"https://api.github.com/repos/craftpip/testrepo/events","assignees_url":"https://api.github.com/repos/craftpip/testrepo/assignees{/user}","branches_url":"https://api.github.com/repos/craftpip/testrepo/branches{/branch}","tags_url":"https://api.github.com/repos/craftpip/testrepo/tags","blobs_url":"https://api.github.com/repos/craftpip/testrepo/git/blobs{/sha}","git_tags_url":"https://api.github.com/repos/craftpip/testrepo/git/tags{/sha}","git_refs_url":"https://api.github.com/repos/craftpip/testrepo/git/refs{/sha}","trees_url":"https://api.github.com/repos/craftpip/testrepo/git/trees{/sha}","statuses_url":"https://api.github.com/repos/craftpip/testrepo/statuses/{sha}","languages_url":"https://api.github.com/repos/craftpip/testrepo/languages","stargazers_url":"https://api.github.com/repos/craftpip/testrepo/stargazers","contributors_url":"https://api.github.com/repos/craftpip/testrepo/contributors","subscribers_url":"https://api.github.com/repos/craftpip/testrepo/subscribers","subscription_url":"https://api.github.com/repos/craftpip/testrepo/subscription","commits_url":"https://api.github.com/repos/craftpip/testrepo/commits{/sha}","git_commits_url":"https://api.github.com/repos/craftpip/testrepo/git/commits{/sha}","comments_url":"https://api.github.com/repos/craftpip/testrepo/comments{/number}","issue_comment_url":"https://api.github.com/repos/craftpip/testrepo/issues/comments{/number}","contents_url":"https://api.github.com/repos/craftpip/testrepo/contents/{+path}","compare_url":"https://api.github.com/repos/craftpip/testrepo/compare/{base}...{head}","merges_url":"https://api.github.com/repos/craftpip/testrepo/merges","archive_url":"https://api.github.com/repos/craftpip/testrepo/{archive_format}{/ref}","downloads_url":"https://api.github.com/repos/craftpip/testrepo/downloads","issues_url":"https://api.github.com/repos/craftpip/testrepo/issues{/number}","pulls_url":"https://api.github.com/repos/craftpip/testrepo/pulls{/number}","milestones_url":"https://api.github.com/repos/craftpip/testrepo/milestones{/number}","notifications_url":"https://api.github.com/repos/craftpip/testrepo/notifications{?since,all,participating}","labels_url":"https://api.github.com/repos/craftpip/testrepo/labels{/name}","releases_url":"https://api.github.com/repos/craftpip/testrepo/releases{/id}","created_at":1428173050,"updated_at":"2015-07-09T09:29:05Z","pushed_at":1436981916,"git_url":"git://github.com/craftpip/testrepo.git","ssh_url":"git@github.com:craftpip/testrepo.git","clone_url":"https://github.com/craftpip/testrepo.git","svn_url":"https://github.com/craftpip/testrepo","homepage":"","size":2744,"stargazers_count":0,"watchers_count":0,"language":null,"has_issues":true,"has_downloads":true,"has_wiki":true,"has_pages":false,"forks_count":0,"mirror_url":null,"open_issues_count":0,"forks":0,"open_issues":0,"watchers":0,"default_branch":"master","stargazers":0,"master_branch":"master"},"pusher":{"name":"craftpip","email":"bonifacepereira@gmail.com"},"sender":{"login":"craftpip","id":4782473,"avatar_url":"https://avatars.githubusercontent.com/u/4782473?v=3","gravatar_id":"","url":"https://api.github.com/users/craftpip","html_url":"https://github.com/craftpip","followers_url":"https://api.github.com/users/craftpip/followers","following_url":"https://api.github.com/users/craftpip/following{/other_user}","gists_url":"https://api.github.com/users/craftpip/gists{/gist_id}","starred_url":"https://api.github.com/users/craftpip/starred{/owner}{/repo}","subscriptions_url":"https://api.github.com/users/craftpip/subscriptions","organizations_url":"https://api.github.com/users/craftpip/orgs","repos_url":"https://api.github.com/users/craftpip/repos","events_url":"https://api.github.com/users/craftpip/events{/privacy}","received_events_url":"https://api.github.com/users/craftpip/received_events","type":"User","site_admin":false}}');
INSERT INTO `log` (`id`, `a`) VALUES
	(288, 'a:1:{i:0;a:11:{s:2:"id";s:2:"40";s:10:"repository";s:40:"https://github.com/craftpip/testrepo.git";s:6:"active";s:1:"1";s:4:"name";s:9:"good test";s:7:"user_id";s:3:"228";s:8:"username";s:0:"";s:8:"password";s:0:"";s:3:"key";s:7:"asdasda";s:6:"cloned";s:1:"1";s:10:"created_at";s:19:"2015-07-12 21:37:32";s:6:"status";s:4:"Idle";}}');
INSERT INTO `log` (`id`, `a`) VALUES
	(289, 'service: github');
INSERT INTO `log` (`id`, `a`) VALUES
	(290, 'a:7:{s:4:"user";s:8:"craftpip";s:10:"avatar_url";s:51:"https://avatars.githubusercontent.com/u/4782473?v=3";s:4:"hash";s:40:"7cfe41f8e38e42691823517bab72658d392db19a";s:9:"post_data";s:7137:"O:8:"stdClass":13:{s:3:"ref";s:17:"refs/heads/master";s:6:"before";s:40:"e3100afa464290a6f28215f74a960269925a6cc6";s:5:"after";s:40:"7cfe41f8e38e42691823517bab72658d392db19a";s:7:"created";b:0;s:7:"deleted";b:0;s:6:"forced";b:0;s:8:"base_ref";N;s:7:"compare";s:72:"https://github.com/craftpip/testrepo/compare/e3100afa4642...7cfe41f8e38e";s:7:"commits";a:1:{i:0;O:8:"stdClass":10:{s:2:"id";s:40:"7cfe41f8e38e42691823517bab72658d392db19a";s:8:"distinct";b:1;s:7:"message";s:5:"asdsa";s:9:"timestamp";s:25:"2015-07-15T23:08:20+05:30";s:3:"url";s:84:"https://github.com/craftpip/testrepo/commit/7cfe41f8e38e42691823517bab72658d392db19a";s:6:"author";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:9:"committer";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:5:"added";a:0:{}s:7:"removed";a:1:{i:0;s:13:"New File3.txt";}s:8:"modified";a:0:{}}}s:11:"head_commit";O:8:"stdClass":10:{s:2:"id";s:40:"7cfe41f8e38e42691823517bab72658d392db19a";s:8:"distinct";b:1;s:7:"message";s:5:"asdsa";s:9:"timestamp";s:25:"2015-07-15T23:08:20+05:30";s:3:"url";s:84:"https://github.com/craftpip/testrepo/commit/7cfe41f8e38e42691823517bab72658d392db19a";s:6:"author";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:9:"committer";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:5:"added";a:0:{}s:7:"removed";a:1:{i:0;s:13:"New File3.txt";}s:8:"modified";a:0:{}}s:10:"repository";O:8:"stdClass":69:{s:2:"id";i:33416050;s:4:"name";s:8:"testrepo";s:9:"full_name";s:17:"craftpip/testrepo";s:5:"owner";O:8:"stdClass":2:{s:4:"name";s:8:"craftpip";s:5:"email";s:25:"bonifacepereira@gmail.com";}s:7:"private";b:0;s:8:"html_url";s:36:"https://github.com/craftpip/testrepo";s:11:"description";s:18:"my git playground.";s:4:"fork";b:0;s:3:"url";s:36:"https://github.com/craftpip/testrepo";s:9:"forks_url";s:52:"https://api.github.com/repos/craftpip/testrepo/forks";s:8:"keys_url";s:60:"https://api.github.com/repos/craftpip/testrepo/keys{/key_id}";s:17:"collaborators_url";s:75:"https://api.github.com/repos/craftpip/testrepo/collaborators{/collaborator}";s:9:"teams_url";s:52:"https://api.github.com/repos/craftpip/testrepo/teams";s:9:"hooks_url";s:52:"https://api.github.com/repos/craftpip/testrepo/hooks";s:16:"issue_events_url";s:69:"https://api.github.com/repos/craftpip/testrepo/issues/events{/number}";s:10:"events_url";s:53:"https://api.github.com/repos/craftpip/testrepo/events";s:13:"assignees_url";s:63:"https://api.github.com/repos/craftpip/testrepo/assignees{/user}";s:12:"branches_url";s:64:"https://api.github.com/repos/craftpip/testrepo/branches{/branch}";s:8:"tags_url";s:51:"https://api.github.com/repos/craftpip/testrepo/tags";s:9:"blobs_url";s:62:"https://api.github.com/repos/craftpip/testrepo/git/blobs{/sha}";s:12:"git_tags_url";s:61:"https://api.github.com/repos/craftpip/testrepo/git/tags{/sha}";s:12:"git_refs_url";s:61:"https://api.github.com/repos/craftpip/testrepo/git/refs{/sha}";s:9:"trees_url";s:62:"https://api.github.com/repos/craftpip/testrepo/git/trees{/sha}";s:12:"statuses_url";s:61:"https://api.github.com/repos/craftpip/testrepo/statuses/{sha}";s:13:"languages_url";s:56:"https://api.github.com/repos/craftpip/testrepo/languages";s:14:"stargazers_url";s:57:"https://api.github.com/repos/craftpip/testrepo/stargazers";s:16:"contributors_url";s:59:"https://api.github.com/repos/craftpip/testrepo/contributors";s:15:"subscribers_url";s:58:"https://api.github.com/repos/craftpip/testrepo/subscribers";s:16:"subscription_url";s:59:"https://api.github.com/repos/craftpip/testrepo/subscription";s:11:"commits_url";s:60:"https://api.github.com/repos/craftpip/testrepo/commits{/sha}";s:15:"git_commits_url";s:64:"https://api.github.com/repos/craftpip/testrepo/git/commits{/sha}";s:12:"comments_url";s:64:"https://api.github.com/repos/craftpip/testrepo/comments{/number}";s:17:"issue_comment_url";s:71:"https://api.github.com/repos/craftpip/testrepo/issues/comments{/number}";s:12:"contents_url";s:63:"https://api.github.com/repos/craftpip/testrepo/contents/{+path}";s:11:"compare_url";s:70:"https://api.github.com/repos/craftpip/testrepo/compare/{base}...{head}";s:10:"merges_url";s:53:"https://api.github.com/repos/craftpip/testrepo/merges";s:11:"archive_url";s:69:"https://api.github.com/repos/craftpip/testrepo/{archive_format}{/ref}";s:13:"downloads_url";s:56:"https://api.github.com/repos/craftpip/testrepo/downloads";s:10:"issues_url";s:62:"https://api.github.com/repos/craftpip/testrepo/issues{/number}";s:9:"pulls_url";s:61:"https://api.github.com/repos/craftpip/testrepo/pulls{/number}";s:14:"milestones_url";s:66:"https://api.github.com/repos/craftpip/testrepo/milestones{/number}";s:17:"notifications_url";s:86:"https://api.github.com/repos/craftpip/testrepo/notifications{?since,all,participating}";s:10:"labels_url";s:60:"https://api.github.com/repos/craftpip/testrepo/labels{/name}";s:12:"releases_url";s:60:"https://api.github.com/repos/craftpip/testrepo/releases{/id}";s:10:"created_at";i:1428173050;s:10:"updated_at";s:20:"2015-07-09T09:29:05Z";s:9:"pushed_at";i:1436981916;s:7:"git_url";s:38:"git://github.com/craftpip/testrepo.git";s:7:"ssh_url";s:36:"git@github.com:craftpip/testrepo.git";s:9:"clone_url";s:40:"https://github.com/craftpip/testrepo.git";s:7:"svn_url";s:36:"https://github.com/craftpip/testrepo";s:8:"homepage";s:0:"";s:4:"size";i:2744;s:16:"stargazers_count";i:0;s:14:"watchers_count";i:0;s:8:"language";N;s:10:"has_issues";b:1;s:13:"has_downloads";b:1;s:8:"has_wiki";b:1;s:9:"has_pages";b:0;s:11:"forks_count";i:0;s:10:"mirror_url";N;s:17:"open_issues_count";i:0;s:5:"forks";i:0;s:11:"open_issues";i:0;s:8:"watchers";i:0;s:14:"default_branch";s:6:"master";s:10:"stargazers";i:0;s:13:"master_branch";s:6:"master";}s:6:"pusher";O:8:"stdClass":2:{s:4:"name";s:8:"craftpip";s:5:"email";s:25:"bonifacepereira@gmail.com";}s:6:"sender";O:8:"stdClass":17:{s:5:"login";s:8:"craftpip";s:2:"id";i:4782473;s:10:"avatar_url";s:51:"https://avatars.githubusercontent.com/u/4782473?v=3";s:11:"gravatar_id";s:0:"";s:3:"url";s:37:"https://api.github.com/users/craftpip";s:8:"html_url";s:27:"https://github.com/craftpip";s:13:"followers_url";s:47:"https://api.github.com/users/craftpip/followers";s:13:"following_url";s:60:"https://api.github.com/users/craftpip/following{/other_user}";s:9:"gists_url";s:53:"https://api.github.com/users/craftpip/gists{/gist_id}";s:11:"starred_url";s:60:"https://api.github.com/users/craftpip/starred{/owner}{/repo}";s:17:"subscriptions_url";s:51:"https://api.github.com/users/craftpip/subscriptions";s:17:"organizations_url";s:42:"https://api.github.com/users/craftpip/orgs";s:9:"repos_url";s:43:"https://api.github.com/users/craftpip/repos";s:10:"events_url";s:54:"https://api.github.com/users/craftpip/events{/privacy}";s:19:"received_events_url";s:53:"https://api.github.com/users/craftpip/received_events";s:4:"type";s:4:"User";s:10:"site_admin";b:0;}}";s:12:"commit_count";i:1;s:14:"commit_message";s:5:"asdsa";s:6:"branch";s:6:"master";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(291, '{"ref":"refs/heads/master","before":"7cfe41f8e38e42691823517bab72658d392db19a","after":"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a","created":false,"deleted":false,"forced":false,"base_ref":null,"compare":"https://github.com/craftpip/testrepo/compare/7cfe41f8e38e...ed2d6178192a","commits":[{"id":"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a","distinct":true,"message":"asdas","timestamp":"2015-07-15T23:13:15+05:30","url":"https://github.com/craftpip/testrepo/commit/ed2d6178192a2c5cbbac977f8f7b4b402f64a32a","author":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"committer":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"added":[],"removed":["New File2.txt"],"modified":[]}],"head_commit":{"id":"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a","distinct":true,"message":"asdas","timestamp":"2015-07-15T23:13:15+05:30","url":"https://github.com/craftpip/testrepo/commit/ed2d6178192a2c5cbbac977f8f7b4b402f64a32a","author":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"committer":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"added":[],"removed":["New File2.txt"],"modified":[]},"repository":{"id":33416050,"name":"testrepo","full_name":"craftpip/testrepo","owner":{"name":"craftpip","email":"bonifacepereira@gmail.com"},"private":false,"html_url":"https://github.com/craftpip/testrepo","description":"my git playground.","fork":false,"url":"https://github.com/craftpip/testrepo","forks_url":"https://api.github.com/repos/craftpip/testrepo/forks","keys_url":"https://api.github.com/repos/craftpip/testrepo/keys{/key_id}","collaborators_url":"https://api.github.com/repos/craftpip/testrepo/collaborators{/collaborator}","teams_url":"https://api.github.com/repos/craftpip/testrepo/teams","hooks_url":"https://api.github.com/repos/craftpip/testrepo/hooks","issue_events_url":"https://api.github.com/repos/craftpip/testrepo/issues/events{/number}","events_url":"https://api.github.com/repos/craftpip/testrepo/events","assignees_url":"https://api.github.com/repos/craftpip/testrepo/assignees{/user}","branches_url":"https://api.github.com/repos/craftpip/testrepo/branches{/branch}","tags_url":"https://api.github.com/repos/craftpip/testrepo/tags","blobs_url":"https://api.github.com/repos/craftpip/testrepo/git/blobs{/sha}","git_tags_url":"https://api.github.com/repos/craftpip/testrepo/git/tags{/sha}","git_refs_url":"https://api.github.com/repos/craftpip/testrepo/git/refs{/sha}","trees_url":"https://api.github.com/repos/craftpip/testrepo/git/trees{/sha}","statuses_url":"https://api.github.com/repos/craftpip/testrepo/statuses/{sha}","languages_url":"https://api.github.com/repos/craftpip/testrepo/languages","stargazers_url":"https://api.github.com/repos/craftpip/testrepo/stargazers","contributors_url":"https://api.github.com/repos/craftpip/testrepo/contributors","subscribers_url":"https://api.github.com/repos/craftpip/testrepo/subscribers","subscription_url":"https://api.github.com/repos/craftpip/testrepo/subscription","commits_url":"https://api.github.com/repos/craftpip/testrepo/commits{/sha}","git_commits_url":"https://api.github.com/repos/craftpip/testrepo/git/commits{/sha}","comments_url":"https://api.github.com/repos/craftpip/testrepo/comments{/number}","issue_comment_url":"https://api.github.com/repos/craftpip/testrepo/issues/comments{/number}","contents_url":"https://api.github.com/repos/craftpip/testrepo/contents/{+path}","compare_url":"https://api.github.com/repos/craftpip/testrepo/compare/{base}...{head}","merges_url":"https://api.github.com/repos/craftpip/testrepo/merges","archive_url":"https://api.github.com/repos/craftpip/testrepo/{archive_format}{/ref}","downloads_url":"https://api.github.com/repos/craftpip/testrepo/downloads","issues_url":"https://api.github.com/repos/craftpip/testrepo/issues{/number}","pulls_url":"https://api.github.com/repos/craftpip/testrepo/pulls{/number}","milestones_url":"https://api.github.com/repos/craftpip/testrepo/milestones{/number}","notifications_url":"https://api.github.com/repos/craftpip/testrepo/notifications{?since,all,participating}","labels_url":"https://api.github.com/repos/craftpip/testrepo/labels{/name}","releases_url":"https://api.github.com/repos/craftpip/testrepo/releases{/id}","created_at":1428173050,"updated_at":"2015-07-09T09:29:05Z","pushed_at":1436982205,"git_url":"git://github.com/craftpip/testrepo.git","ssh_url":"git@github.com:craftpip/testrepo.git","clone_url":"https://github.com/craftpip/testrepo.git","svn_url":"https://github.com/craftpip/testrepo","homepage":"","size":2744,"stargazers_count":0,"watchers_count":0,"language":null,"has_issues":true,"has_downloads":true,"has_wiki":true,"has_pages":false,"forks_count":0,"mirror_url":null,"open_issues_count":0,"forks":0,"open_issues":0,"watchers":0,"default_branch":"master","stargazers":0,"master_branch":"master"},"pusher":{"name":"craftpip","email":"bonifacepereira@gmail.com"},"sender":{"login":"craftpip","id":4782473,"avatar_url":"https://avatars.githubusercontent.com/u/4782473?v=3","gravatar_id":"","url":"https://api.github.com/users/craftpip","html_url":"https://github.com/craftpip","followers_url":"https://api.github.com/users/craftpip/followers","following_url":"https://api.github.com/users/craftpip/following{/other_user}","gists_url":"https://api.github.com/users/craftpip/gists{/gist_id}","starred_url":"https://api.github.com/users/craftpip/starred{/owner}{/repo}","subscriptions_url":"https://api.github.com/users/craftpip/subscriptions","organizations_url":"https://api.github.com/users/craftpip/orgs","repos_url":"https://api.github.com/users/craftpip/repos","events_url":"https://api.github.com/users/craftpip/events{/privacy}","received_events_url":"https://api.github.com/users/craftpip/received_events","type":"User","site_admin":false}}');
INSERT INTO `log` (`id`, `a`) VALUES
	(292, 'a:1:{i:0;a:11:{s:2:"id";s:2:"40";s:10:"repository";s:40:"https://github.com/craftpip/testrepo.git";s:6:"active";s:1:"1";s:4:"name";s:9:"good test";s:7:"user_id";s:3:"228";s:8:"username";s:0:"";s:8:"password";s:0:"";s:3:"key";s:7:"asdasda";s:6:"cloned";s:1:"1";s:10:"created_at";s:19:"2015-07-12 21:37:32";s:6:"status";s:4:"Idle";}}');
INSERT INTO `log` (`id`, `a`) VALUES
	(293, 'service: github');
INSERT INTO `log` (`id`, `a`) VALUES
	(294, 'a:7:{s:4:"user";s:8:"craftpip";s:10:"avatar_url";s:51:"https://avatars.githubusercontent.com/u/4782473?v=3";s:4:"hash";s:40:"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a";s:9:"post_data";s:7137:"O:8:"stdClass":13:{s:3:"ref";s:17:"refs/heads/master";s:6:"before";s:40:"7cfe41f8e38e42691823517bab72658d392db19a";s:5:"after";s:40:"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a";s:7:"created";b:0;s:7:"deleted";b:0;s:6:"forced";b:0;s:8:"base_ref";N;s:7:"compare";s:72:"https://github.com/craftpip/testrepo/compare/7cfe41f8e38e...ed2d6178192a";s:7:"commits";a:1:{i:0;O:8:"stdClass":10:{s:2:"id";s:40:"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a";s:8:"distinct";b:1;s:7:"message";s:5:"asdas";s:9:"timestamp";s:25:"2015-07-15T23:13:15+05:30";s:3:"url";s:84:"https://github.com/craftpip/testrepo/commit/ed2d6178192a2c5cbbac977f8f7b4b402f64a32a";s:6:"author";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:9:"committer";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:5:"added";a:0:{}s:7:"removed";a:1:{i:0;s:13:"New File2.txt";}s:8:"modified";a:0:{}}}s:11:"head_commit";O:8:"stdClass":10:{s:2:"id";s:40:"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a";s:8:"distinct";b:1;s:7:"message";s:5:"asdas";s:9:"timestamp";s:25:"2015-07-15T23:13:15+05:30";s:3:"url";s:84:"https://github.com/craftpip/testrepo/commit/ed2d6178192a2c5cbbac977f8f7b4b402f64a32a";s:6:"author";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:9:"committer";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:5:"added";a:0:{}s:7:"removed";a:1:{i:0;s:13:"New File2.txt";}s:8:"modified";a:0:{}}s:10:"repository";O:8:"stdClass":69:{s:2:"id";i:33416050;s:4:"name";s:8:"testrepo";s:9:"full_name";s:17:"craftpip/testrepo";s:5:"owner";O:8:"stdClass":2:{s:4:"name";s:8:"craftpip";s:5:"email";s:25:"bonifacepereira@gmail.com";}s:7:"private";b:0;s:8:"html_url";s:36:"https://github.com/craftpip/testrepo";s:11:"description";s:18:"my git playground.";s:4:"fork";b:0;s:3:"url";s:36:"https://github.com/craftpip/testrepo";s:9:"forks_url";s:52:"https://api.github.com/repos/craftpip/testrepo/forks";s:8:"keys_url";s:60:"https://api.github.com/repos/craftpip/testrepo/keys{/key_id}";s:17:"collaborators_url";s:75:"https://api.github.com/repos/craftpip/testrepo/collaborators{/collaborator}";s:9:"teams_url";s:52:"https://api.github.com/repos/craftpip/testrepo/teams";s:9:"hooks_url";s:52:"https://api.github.com/repos/craftpip/testrepo/hooks";s:16:"issue_events_url";s:69:"https://api.github.com/repos/craftpip/testrepo/issues/events{/number}";s:10:"events_url";s:53:"https://api.github.com/repos/craftpip/testrepo/events";s:13:"assignees_url";s:63:"https://api.github.com/repos/craftpip/testrepo/assignees{/user}";s:12:"branches_url";s:64:"https://api.github.com/repos/craftpip/testrepo/branches{/branch}";s:8:"tags_url";s:51:"https://api.github.com/repos/craftpip/testrepo/tags";s:9:"blobs_url";s:62:"https://api.github.com/repos/craftpip/testrepo/git/blobs{/sha}";s:12:"git_tags_url";s:61:"https://api.github.com/repos/craftpip/testrepo/git/tags{/sha}";s:12:"git_refs_url";s:61:"https://api.github.com/repos/craftpip/testrepo/git/refs{/sha}";s:9:"trees_url";s:62:"https://api.github.com/repos/craftpip/testrepo/git/trees{/sha}";s:12:"statuses_url";s:61:"https://api.github.com/repos/craftpip/testrepo/statuses/{sha}";s:13:"languages_url";s:56:"https://api.github.com/repos/craftpip/testrepo/languages";s:14:"stargazers_url";s:57:"https://api.github.com/repos/craftpip/testrepo/stargazers";s:16:"contributors_url";s:59:"https://api.github.com/repos/craftpip/testrepo/contributors";s:15:"subscribers_url";s:58:"https://api.github.com/repos/craftpip/testrepo/subscribers";s:16:"subscription_url";s:59:"https://api.github.com/repos/craftpip/testrepo/subscription";s:11:"commits_url";s:60:"https://api.github.com/repos/craftpip/testrepo/commits{/sha}";s:15:"git_commits_url";s:64:"https://api.github.com/repos/craftpip/testrepo/git/commits{/sha}";s:12:"comments_url";s:64:"https://api.github.com/repos/craftpip/testrepo/comments{/number}";s:17:"issue_comment_url";s:71:"https://api.github.com/repos/craftpip/testrepo/issues/comments{/number}";s:12:"contents_url";s:63:"https://api.github.com/repos/craftpip/testrepo/contents/{+path}";s:11:"compare_url";s:70:"https://api.github.com/repos/craftpip/testrepo/compare/{base}...{head}";s:10:"merges_url";s:53:"https://api.github.com/repos/craftpip/testrepo/merges";s:11:"archive_url";s:69:"https://api.github.com/repos/craftpip/testrepo/{archive_format}{/ref}";s:13:"downloads_url";s:56:"https://api.github.com/repos/craftpip/testrepo/downloads";s:10:"issues_url";s:62:"https://api.github.com/repos/craftpip/testrepo/issues{/number}";s:9:"pulls_url";s:61:"https://api.github.com/repos/craftpip/testrepo/pulls{/number}";s:14:"milestones_url";s:66:"https://api.github.com/repos/craftpip/testrepo/milestones{/number}";s:17:"notifications_url";s:86:"https://api.github.com/repos/craftpip/testrepo/notifications{?since,all,participating}";s:10:"labels_url";s:60:"https://api.github.com/repos/craftpip/testrepo/labels{/name}";s:12:"releases_url";s:60:"https://api.github.com/repos/craftpip/testrepo/releases{/id}";s:10:"created_at";i:1428173050;s:10:"updated_at";s:20:"2015-07-09T09:29:05Z";s:9:"pushed_at";i:1436982205;s:7:"git_url";s:38:"git://github.com/craftpip/testrepo.git";s:7:"ssh_url";s:36:"git@github.com:craftpip/testrepo.git";s:9:"clone_url";s:40:"https://github.com/craftpip/testrepo.git";s:7:"svn_url";s:36:"https://github.com/craftpip/testrepo";s:8:"homepage";s:0:"";s:4:"size";i:2744;s:16:"stargazers_count";i:0;s:14:"watchers_count";i:0;s:8:"language";N;s:10:"has_issues";b:1;s:13:"has_downloads";b:1;s:8:"has_wiki";b:1;s:9:"has_pages";b:0;s:11:"forks_count";i:0;s:10:"mirror_url";N;s:17:"open_issues_count";i:0;s:5:"forks";i:0;s:11:"open_issues";i:0;s:8:"watchers";i:0;s:14:"default_branch";s:6:"master";s:10:"stargazers";i:0;s:13:"master_branch";s:6:"master";}s:6:"pusher";O:8:"stdClass":2:{s:4:"name";s:8:"craftpip";s:5:"email";s:25:"bonifacepereira@gmail.com";}s:6:"sender";O:8:"stdClass":17:{s:5:"login";s:8:"craftpip";s:2:"id";i:4782473;s:10:"avatar_url";s:51:"https://avatars.githubusercontent.com/u/4782473?v=3";s:11:"gravatar_id";s:0:"";s:3:"url";s:37:"https://api.github.com/users/craftpip";s:8:"html_url";s:27:"https://github.com/craftpip";s:13:"followers_url";s:47:"https://api.github.com/users/craftpip/followers";s:13:"following_url";s:60:"https://api.github.com/users/craftpip/following{/other_user}";s:9:"gists_url";s:53:"https://api.github.com/users/craftpip/gists{/gist_id}";s:11:"starred_url";s:60:"https://api.github.com/users/craftpip/starred{/owner}{/repo}";s:17:"subscriptions_url";s:51:"https://api.github.com/users/craftpip/subscriptions";s:17:"organizations_url";s:42:"https://api.github.com/users/craftpip/orgs";s:9:"repos_url";s:43:"https://api.github.com/users/craftpip/repos";s:10:"events_url";s:54:"https://api.github.com/users/craftpip/events{/privacy}";s:19:"received_events_url";s:53:"https://api.github.com/users/craftpip/received_events";s:4:"type";s:4:"User";s:10:"site_admin";b:0;}}";s:12:"commit_count";i:1;s:14:"commit_message";s:5:"asdas";s:6:"branch";s:6:"master";}');
INSERT INTO `log` (`id`, `a`) VALUES
	(295, '{"ref":"refs/heads/master","before":"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a","after":"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25","created":false,"deleted":false,"forced":false,"base_ref":null,"compare":"https://github.com/craftpip/testrepo/compare/ed2d6178192a...9d9fcb967db0","commits":[{"id":"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25","distinct":true,"message":"asdsada","timestamp":"2015-07-15T23:22:17+05:30","url":"https://github.com/craftpip/testrepo/commit/9d9fcb967db09fb979051b1450dc6fdd1c7d7b25","author":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"committer":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"added":["New File - Copy (2).txt","New File - Copy (3).txt","New File - Copy (4).txt","New File - Copy (5).txt","New File - Copy (6).txt","New File - Copy (7).txt","New File - Copy (8).txt","New File - Copy (9).txt","New File - Copy.txt","asdasdas/New File - Copy (7).txt","asdasdas/New File - Copy (8).txt","asdasdas/New File - Copy (9).txt","asdasdas/New File - Copy.txt","asdasdas/New File.txt","asdsada/New File - Copy (7).txt","asdsada/New File - Copy (8).txt","asdsada/New File - Copy (9).txt","asdsada/New File - Copy.txt","asdsada/New File.txt"],"removed":[],"modified":[]}],"head_commit":{"id":"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25","distinct":true,"message":"asdsada","timestamp":"2015-07-15T23:22:17+05:30","url":"https://github.com/craftpip/testrepo/commit/9d9fcb967db09fb979051b1450dc6fdd1c7d7b25","author":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"committer":{"name":"Boniface Pereira","email":"bonifacepereira@gmail.com","username":"craftpip"},"added":["New File - Copy (2).txt","New File - Copy (3).txt","New File - Copy (4).txt","New File - Copy (5).txt","New File - Copy (6).txt","New File - Copy (7).txt","New File - Copy (8).txt","New File - Copy (9).txt","New File - Copy.txt","asdasdas/New File - Copy (7).txt","asdasdas/New File - Copy (8).txt","asdasdas/New File - Copy (9).txt","asdasdas/New File - Copy.txt","asdasdas/New File.txt","asdsada/New File - Copy (7).txt","asdsada/New File - Copy (8).txt","asdsada/New File - Copy (9).txt","asdsada/New File - Copy.txt","asdsada/New File.txt"],"removed":[],"modified":[]},"repository":{"id":33416050,"name":"testrepo","full_name":"craftpip/testrepo","owner":{"name":"craftpip","email":"bonifacepereira@gmail.com"},"private":false,"html_url":"https://github.com/craftpip/testrepo","description":"my git playground.","fork":false,"url":"https://github.com/craftpip/testrepo","forks_url":"https://api.github.com/repos/craftpip/testrepo/forks","keys_url":"https://api.github.com/repos/craftpip/testrepo/keys{/key_id}","collaborators_url":"https://api.github.com/repos/craftpip/testrepo/collaborators{/collaborator}","teams_url":"https://api.github.com/repos/craftpip/testrepo/teams","hooks_url":"https://api.github.com/repos/craftpip/testrepo/hooks","issue_events_url":"https://api.github.com/repos/craftpip/testrepo/issues/events{/number}","events_url":"https://api.github.com/repos/craftpip/testrepo/events","assignees_url":"https://api.github.com/repos/craftpip/testrepo/assignees{/user}","branches_url":"https://api.github.com/repos/craftpip/testrepo/branches{/branch}","tags_url":"https://api.github.com/repos/craftpip/testrepo/tags","blobs_url":"https://api.github.com/repos/craftpip/testrepo/git/blobs{/sha}","git_tags_url":"https://api.github.com/repos/craftpip/testrepo/git/tags{/sha}","git_refs_url":"https://api.github.com/repos/craftpip/testrepo/git/refs{/sha}","trees_url":"https://api.github.com/repos/craftpip/testrepo/git/trees{/sha}","statuses_url":"https://api.github.com/repos/craftpip/testrepo/statuses/{sha}","languages_url":"https://api.github.com/repos/craftpip/testrepo/languages","stargazers_url":"https://api.github.com/repos/craftpip/testrepo/stargazers","contributors_url":"https://api.github.com/repos/craftpip/testrepo/contributors","subscribers_url":"https://api.github.com/repos/craftpip/testrepo/subscribers","subscription_url":"https://api.github.com/repos/craftpip/testrepo/subscription","commits_url":"https://api.github.com/repos/craftpip/testrepo/commits{/sha}","git_commits_url":"https://api.github.com/repos/craftpip/testrepo/git/commits{/sha}","comments_url":"https://api.github.com/repos/craftpip/testrepo/comments{/number}","issue_comment_url":"https://api.github.com/repos/craftpip/testrepo/issues/comments{/number}","contents_url":"https://api.github.com/repos/craftpip/testrepo/contents/{+path}","compare_url":"https://api.github.com/repos/craftpip/testrepo/compare/{base}...{head}","merges_url":"https://api.github.com/repos/craftpip/testrepo/merges","archive_url":"https://api.github.com/repos/craftpip/testrepo/{archive_format}{/ref}","downloads_url":"https://api.github.com/repos/craftpip/testrepo/downloads","issues_url":"https://api.github.com/repos/craftpip/testrepo/issues{/number}","pulls_url":"https://api.github.com/repos/craftpip/testrepo/pulls{/number}","milestones_url":"https://api.github.com/repos/craftpip/testrepo/milestones{/number}","notifications_url":"https://api.github.com/repos/craftpip/testrepo/notifications{?since,all,participating}","labels_url":"https://api.github.com/repos/craftpip/testrepo/labels{/name}","releases_url":"https://api.github.com/repos/craftpip/testrepo/releases{/id}","created_at":1428173050,"updated_at":"2015-07-09T09:29:05Z","pushed_at":1436982750,"git_url":"git://github.com/craftpip/testrepo.git","ssh_url":"git@github.com:craftpip/testrepo.git","clone_url":"https://github.com/craftpip/testrepo.git","svn_url":"https://github.com/craftpip/testrepo","homepage":"","size":2744,"stargazers_count":0,"watchers_count":0,"language":null,"has_issues":true,"has_downloads":true,"has_wiki":true,"has_pages":false,"forks_count":0,"mirror_url":null,"open_issues_count":0,"forks":0,"open_issues":0,"watchers":0,"default_branch":"master","stargazers":0,"master_branch":"master"},"pusher":{"name":"craftpip","email":"bonifacepereira@gmail.com"},"sender":{"login":"craftpip","id":4782473,"avatar_url":"https://avatars.githubusercontent.com/u/4782473?v=3","gravatar_id":"","url":"https://api.github.com/users/craftpip","html_url":"https://github.com/craftpip","followers_url":"https://api.github.com/users/craftpip/followers","following_url":"https://api.github.com/users/craftpip/following{/other_user}","gists_url":"https://api.github.com/users/craftpip/gists{/gist_id}","starred_url":"https://api.github.com/users/craftpip/starred{/owner}{/repo}","subscriptions_url":"https://api.github.com/users/craftpip/subscriptions","organizations_url":"https://api.github.com/users/craftpip/orgs","repos_url":"https://api.github.com/users/craftpip/repos","events_url":"https://api.github.com/users/craftpip/events{/privacy}","received_events_url":"https://api.github.com/users/craftpip/received_events","type":"User","site_admin":false}}');
INSERT INTO `log` (`id`, `a`) VALUES
	(296, 'a:1:{i:0;a:11:{s:2:"id";s:2:"40";s:10:"repository";s:40:"https://github.com/craftpip/testrepo.git";s:6:"active";s:1:"1";s:4:"name";s:9:"good test";s:7:"user_id";s:3:"228";s:8:"username";s:0:"";s:8:"password";s:0:"";s:3:"key";s:7:"asdasda";s:6:"cloned";s:1:"1";s:10:"created_at";s:19:"2015-07-12 21:37:32";s:6:"status";s:4:"Idle";}}');
INSERT INTO `log` (`id`, `a`) VALUES
	(297, 'service: github');
INSERT INTO `log` (`id`, `a`) VALUES
	(298, 'a:7:{s:4:"user";s:8:"craftpip";s:10:"avatar_url";s:51:"https://avatars.githubusercontent.com/u/4782473?v=3";s:4:"hash";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:9:"post_data";s:8543:"O:8:"stdClass":13:{s:3:"ref";s:17:"refs/heads/master";s:6:"before";s:40:"ed2d6178192a2c5cbbac977f8f7b4b402f64a32a";s:5:"after";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:7:"created";b:0;s:7:"deleted";b:0;s:6:"forced";b:0;s:8:"base_ref";N;s:7:"compare";s:72:"https://github.com/craftpip/testrepo/compare/ed2d6178192a...9d9fcb967db0";s:7:"commits";a:1:{i:0;O:8:"stdClass":10:{s:2:"id";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:8:"distinct";b:1;s:7:"message";s:7:"asdsada";s:9:"timestamp";s:25:"2015-07-15T23:22:17+05:30";s:3:"url";s:84:"https://github.com/craftpip/testrepo/commit/9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:6:"author";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:9:"committer";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:5:"added";a:19:{i:0;s:23:"New File - Copy (2).txt";i:1;s:23:"New File - Copy (3).txt";i:2;s:23:"New File - Copy (4).txt";i:3;s:23:"New File - Copy (5).txt";i:4;s:23:"New File - Copy (6).txt";i:5;s:23:"New File - Copy (7).txt";i:6;s:23:"New File - Copy (8).txt";i:7;s:23:"New File - Copy (9).txt";i:8;s:19:"New File - Copy.txt";i:9;s:32:"asdasdas/New File - Copy (7).txt";i:10;s:32:"asdasdas/New File - Copy (8).txt";i:11;s:32:"asdasdas/New File - Copy (9).txt";i:12;s:28:"asdasdas/New File - Copy.txt";i:13;s:21:"asdasdas/New File.txt";i:14;s:31:"asdsada/New File - Copy (7).txt";i:15;s:31:"asdsada/New File - Copy (8).txt";i:16;s:31:"asdsada/New File - Copy (9).txt";i:17;s:27:"asdsada/New File - Copy.txt";i:18;s:20:"asdsada/New File.txt";}s:7:"removed";a:0:{}s:8:"modified";a:0:{}}}s:11:"head_commit";O:8:"stdClass":10:{s:2:"id";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:8:"distinct";b:1;s:7:"message";s:7:"asdsada";s:9:"timestamp";s:25:"2015-07-15T23:22:17+05:30";s:3:"url";s:84:"https://github.com/craftpip/testrepo/commit/9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:6:"author";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:9:"committer";O:8:"stdClass":3:{s:4:"name";s:16:"Boniface Pereira";s:5:"email";s:25:"bonifacepereira@gmail.com";s:8:"username";s:8:"craftpip";}s:5:"added";a:19:{i:0;s:23:"New File - Copy (2).txt";i:1;s:23:"New File - Copy (3).txt";i:2;s:23:"New File - Copy (4).txt";i:3;s:23:"New File - Copy (5).txt";i:4;s:23:"New File - Copy (6).txt";i:5;s:23:"New File - Copy (7).txt";i:6;s:23:"New File - Copy (8).txt";i:7;s:23:"New File - Copy (9).txt";i:8;s:19:"New File - Copy.txt";i:9;s:32:"asdasdas/New File - Copy (7).txt";i:10;s:32:"asdasdas/New File - Copy (8).txt";i:11;s:32:"asdasdas/New File - Copy (9).txt";i:12;s:28:"asdasdas/New File - Copy.txt";i:13;s:21:"asdasdas/New File.txt";i:14;s:31:"asdsada/New File - Copy (7).txt";i:15;s:31:"asdsada/New File - Copy (8).txt";i:16;s:31:"asdsada/New File - Copy (9).txt";i:17;s:27:"asdsada/New File - Copy.txt";i:18;s:20:"asdsada/New File.txt";}s:7:"removed";a:0:{}s:8:"modified";a:0:{}}s:10:"repository";O:8:"stdClass":69:{s:2:"id";i:33416050;s:4:"name";s:8:"testrepo";s:9:"full_name";s:17:"craftpip/testrepo";s:5:"owner";O:8:"stdClass":2:{s:4:"name";s:8:"craftpip";s:5:"email";s:25:"bonifacepereira@gmail.com";}s:7:"private";b:0;s:8:"html_url";s:36:"https://github.com/craftpip/testrepo";s:11:"description";s:18:"my git playground.";s:4:"fork";b:0;s:3:"url";s:36:"https://github.com/craftpip/testrepo";s:9:"forks_url";s:52:"https://api.github.com/repos/craftpip/testrepo/forks";s:8:"keys_url";s:60:"https://api.github.com/repos/craftpip/testrepo/keys{/key_id}";s:17:"collaborators_url";s:75:"https://api.github.com/repos/craftpip/testrepo/collaborators{/collaborator}";s:9:"teams_url";s:52:"https://api.github.com/repos/craftpip/testrepo/teams";s:9:"hooks_url";s:52:"https://api.github.com/repos/craftpip/testrepo/hooks";s:16:"issue_events_url";s:69:"https://api.github.com/repos/craftpip/testrepo/issues/events{/number}";s:10:"events_url";s:53:"https://api.github.com/repos/craftpip/testrepo/events";s:13:"assignees_url";s:63:"https://api.github.com/repos/craftpip/testrepo/assignees{/user}";s:12:"branches_url";s:64:"https://api.github.com/repos/craftpip/testrepo/branches{/branch}";s:8:"tags_url";s:51:"https://api.github.com/repos/craftpip/testrepo/tags";s:9:"blobs_url";s:62:"https://api.github.com/repos/craftpip/testrepo/git/blobs{/sha}";s:12:"git_tags_url";s:61:"https://api.github.com/repos/craftpip/testrepo/git/tags{/sha}";s:12:"git_refs_url";s:61:"https://api.github.com/repos/craftpip/testrepo/git/refs{/sha}";s:9:"trees_url";s:62:"https://api.github.com/repos/craftpip/testrepo/git/trees{/sha}";s:12:"statuses_url";s:61:"https://api.github.com/repos/craftpip/testrepo/statuses/{sha}";s:13:"languages_url";s:56:"https://api.github.com/repos/craftpip/testrepo/languages";s:14:"stargazers_url";s:57:"https://api.github.com/repos/craftpip/testrepo/stargazers";s:16:"contributors_url";s:59:"https://api.github.com/repos/craftpip/testrepo/contributors";s:15:"subscribers_url";s:58:"https://api.github.com/repos/craftpip/testrepo/subscribers";s:16:"subscription_url";s:59:"https://api.github.com/repos/craftpip/testrepo/subscription";s:11:"commits_url";s:60:"https://api.github.com/repos/craftpip/testrepo/commits{/sha}";s:15:"git_commits_url";s:64:"https://api.github.com/repos/craftpip/testrepo/git/commits{/sha}";s:12:"comments_url";s:64:"https://api.github.com/repos/craftpip/testrepo/comments{/number}";s:17:"issue_comment_url";s:71:"https://api.github.com/repos/craftpip/testrepo/issues/comments{/number}";s:12:"contents_url";s:63:"https://api.github.com/repos/craftpip/testrepo/contents/{+path}";s:11:"compare_url";s:70:"https://api.github.com/repos/craftpip/testrepo/compare/{base}...{head}";s:10:"merges_url";s:53:"https://api.github.com/repos/craftpip/testrepo/merges";s:11:"archive_url";s:69:"https://api.github.com/repos/craftpip/testrepo/{archive_format}{/ref}";s:13:"downloads_url";s:56:"https://api.github.com/repos/craftpip/testrepo/downloads";s:10:"issues_url";s:62:"https://api.github.com/repos/craftpip/testrepo/issues{/number}";s:9:"pulls_url";s:61:"https://api.github.com/repos/craftpip/testrepo/pulls{/number}";s:14:"milestones_url";s:66:"https://api.github.com/repos/craftpip/testrepo/milestones{/number}";s:17:"notifications_url";s:86:"https://api.github.com/repos/craftpip/testrepo/notifications{?since,all,participating}";s:10:"labels_url";s:60:"https://api.github.com/repos/craftpip/testrepo/labels{/name}";s:12:"releases_url";s:60:"https://api.github.com/repos/craftpip/testrepo/releases{/id}";s:10:"created_at";i:1428173050;s:10:"updated_at";s:20:"2015-07-09T09:29:05Z";s:9:"pushed_at";i:1436982750;s:7:"git_url";s:38:"git://github.com/craftpip/testrepo.git";s:7:"ssh_url";s:36:"git@github.com:craftpip/testrepo.git";s:9:"clone_url";s:40:"https://github.com/craftpip/testrepo.git";s:7:"svn_url";s:36:"https://github.com/craftpip/testrepo";s:8:"homepage";s:0:"";s:4:"size";i:2744;s:16:"stargazers_count";i:0;s:14:"watchers_count";i:0;s:8:"language";N;s:10:"has_issues";b:1;s:13:"has_downloads";b:1;s:8:"has_wiki";b:1;s:9:"has_pages";b:0;s:11:"forks_count";i:0;s:10:"mirror_url";N;s:17:"open_issues_count";i:0;s:5:"forks";i:0;s:11:"open_issues";i:0;s:8:"watchers";i:0;s:14:"default_branch";s:6:"master";s:10:"stargazers";i:0;s:13:"master_branch";s:6:"master";}s:6:"pusher";O:8:"stdClass":2:{s:4:"name";s:8:"craftpip";s:5:"email";s:25:"bonifacepereira@gmail.com";}s:6:"sender";O:8:"stdClass":17:{s:5:"login";s:8:"craftpip";s:2:"id";i:4782473;s:10:"avatar_url";s:51:"https://avatars.githubusercontent.com/u/4782473?v=3";s:11:"gravatar_id";s:0:"";s:3:"url";s:37:"https://api.github.com/users/craftpip";s:8:"html_url";s:27:"https://github.com/craftpip";s:13:"followers_url";s:47:"https://api.github.com/users/craftpip/followers";s:13:"following_url";s:60:"https://api.github.com/users/craftpip/following{/other_user}";s:9:"gists_url";s:53:"https://api.github.com/users/craftpip/gists{/gist_id}";s:11:"starred_url";s:60:"https://api.github.com/users/craftpip/starred{/owner}{/repo}";s:17:"subscriptions_url";s:51:"https://api.github.com/users/craftpip/subscriptions";s:17:"organizations_url";s:42:"https://api.github.com/users/craftpip/orgs";s:9:"repos_url";s:43:"https://api.github.com/users/craftpip/repos";s:10:"events_url";s:54:"https://api.github.com/users/craftpip/events{/privacy}";s:19:"received_events_url";s:53:"https://api.github.com/users/craftpip/received_events";s:4:"type";s:4:"User";s:10:"site_admin";b:0;}}";s:12:"commit_count";i:1;s:14:"commit_message";s:7:"asdsada";s:6:"branch";s:6:"master";}');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.migration
DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `type` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `migration` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitploy.migration: ~10 rows (approximately)
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


-- Dumping structure for table craftrzt_gitploy.records
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
  `commit_count` text,
  `commit_message` text,
  `file_add` int(11) NOT NULL DEFAULT '0',
  `file_remove` int(11) NOT NULL DEFAULT '0',
  `file_skip` int(11) NOT NULL DEFAULT '0',
  `file_purge` int(11) NOT NULL DEFAULT '0',
  `total_files` int(11) NOT NULL DEFAULT '0',
  `processed_files` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `deploy_record` (`deploy_id`),
  CONSTRAINT `deploy_record` FOREIGN KEY (`deploy_id`) REFERENCES `deploy` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=900 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.records: ~7 rows (approximately)
DELETE FROM `records`;
/*!40000 ALTER TABLE `records` DISABLE KEYS */;
INSERT INTO `records` (`id`, `deploy_id`, `user_id`, `record_type`, `status`, `branch_id`, `amount_deployed_raw`, `amount_deployed`, `raw`, `date`, `triggerby`, `post_data`, `avatar_url`, `hash_before`, `hash`, `commit_count`, `commit_message`, `file_add`, `file_remove`, `file_skip`, `file_purge`, `total_files`, `processed_files`) VALUES
	(892, 47, 228, 1, 1, 93, 0, '0.00B', 'a:7:{i:0;s:66:"Connection to https://github.com/craftpip/testrepo.git successful.";s:14:"repo_processed";s:3:"Yes";s:11:"ftp_connect";s:9:"connected";s:13:"deploy_branch";s:6:"master";s:17:"deploy_branch_env";s:3:"Dev";s:25:"revision_on_server_before";s:0:"";s:10:"deploy_log";a:6:{i:0;s:19:"Initializing deploy";s:21:"remoteRevision_before";s:0:"";s:5:"files";a:3:{s:6:"upload";i:20;s:6:"delete";i:0;s:4:"skip";i:0;}i:1;s:21:"20 file(s) to process";s:20:"remoteRevision_after";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:8:"deployed";a:2:{s:4:"data";i:0;s:5:"human";s:5:"0.00B";}}}', 1437307414, '', NULL, NULL, '', '9d9fcb967db09fb979051b1450dc6fdd1c7d7b25', NULL, NULL, 20, 0, 0, 0, 20, 20);
INSERT INTO `records` (`id`, `deploy_id`, `user_id`, `record_type`, `status`, `branch_id`, `amount_deployed_raw`, `amount_deployed`, `raw`, `date`, `triggerby`, `post_data`, `avatar_url`, `hash_before`, `hash`, `commit_count`, `commit_message`, `file_add`, `file_remove`, `file_skip`, `file_purge`, `total_files`, `processed_files`) VALUES
	(893, 47, 228, 1, 1, 95, 0, '0.00B', 'a:6:{i:0;s:66:"Connection to https://github.com/craftpip/testrepo.git successful.";s:11:"ftp_connect";s:9:"connected";s:13:"deploy_branch";s:9:"something";s:17:"deploy_branch_env";s:4:"Test";s:25:"revision_on_server_before";s:0:"";s:10:"deploy_log";a:6:{i:0;s:19:"Initializing deploy";s:21:"remoteRevision_before";s:0:"";s:5:"files";a:3:{s:6:"upload";i:2;s:6:"delete";i:0;s:4:"skip";i:0;}i:1;s:20:"2 file(s) to process";s:20:"remoteRevision_after";s:40:"21d73f300175c5673082ea1a05891517d7603729";s:8:"deployed";a:2:{s:4:"data";i:0;s:5:"human";s:5:"0.00B";}}}', 1437307523, '', NULL, NULL, '', '21d73f300175c5673082ea1a05891517d7603729', NULL, NULL, 2, 0, 0, 0, 2, 2);
INSERT INTO `records` (`id`, `deploy_id`, `user_id`, `record_type`, `status`, `branch_id`, `amount_deployed_raw`, `amount_deployed`, `raw`, `date`, `triggerby`, `post_data`, `avatar_url`, `hash_before`, `hash`, `commit_count`, `commit_message`, `file_add`, `file_remove`, `file_skip`, `file_purge`, `total_files`, `processed_files`) VALUES
	(895, 47, 228, 1, 1, 93, 0, '0.00B', 'a:6:{i:0;s:66:"Connection to https://github.com/craftpip/testrepo.git successful.";s:11:"ftp_connect";s:9:"connected";s:13:"deploy_branch";s:6:"master";s:17:"deploy_branch_env";s:6:"Devdas";s:25:"revision_on_server_before";s:0:"";s:10:"deploy_log";a:6:{i:0;s:19:"Initializing deploy";s:21:"remoteRevision_before";s:0:"";s:5:"files";a:3:{s:6:"upload";i:20;s:6:"delete";i:0;s:4:"skip";i:0;}i:1;s:21:"20 file(s) to process";s:20:"remoteRevision_after";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:8:"deployed";a:2:{s:4:"data";i:0;s:5:"human";s:5:"0.00B";}}}', 1437311867, '', NULL, NULL, '', '9d9fcb967db09fb979051b1450dc6fdd1c7d7b25', NULL, NULL, 20, 0, 0, 0, 20, 20);
INSERT INTO `records` (`id`, `deploy_id`, `user_id`, `record_type`, `status`, `branch_id`, `amount_deployed_raw`, `amount_deployed`, `raw`, `date`, `triggerby`, `post_data`, `avatar_url`, `hash_before`, `hash`, `commit_count`, `commit_message`, `file_add`, `file_remove`, `file_skip`, `file_purge`, `total_files`, `processed_files`) VALUES
	(896, 47, 228, 0, 1, 93, 0, '0.00B', 'a:7:{i:0;s:66:"Connection to https://github.com/craftpip/testrepo.git successful.";s:11:"ftp_connect";s:9:"connected";s:13:"deploy_branch";s:6:"master";s:17:"deploy_branch_env";s:6:"Devdas";s:25:"revision_on_server_before";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";i:1;s:34:"FTP server has the latest changes!";s:10:"deploy_log";a:6:{i:0;s:19:"Initializing deploy";s:21:"remoteRevision_before";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:5:"files";a:3:{s:6:"upload";i:0;s:6:"delete";i:0;s:4:"skip";i:0;}i:1;s:20:"0 file(s) to process";s:20:"remoteRevision_after";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:8:"deployed";a:2:{s:4:"data";i:0;s:5:"human";s:5:"0.00B";}}}', 1437327932, '', NULL, NULL, '9d9fcb967db09fb979051b1450dc6fdd1c7d7b25', '9d9fcb967db09fb979051b1450dc6fdd1c7d7b25', NULL, NULL, 0, 0, 0, 0, 0, 0);
INSERT INTO `records` (`id`, `deploy_id`, `user_id`, `record_type`, `status`, `branch_id`, `amount_deployed_raw`, `amount_deployed`, `raw`, `date`, `triggerby`, `post_data`, `avatar_url`, `hash_before`, `hash`, `commit_count`, `commit_message`, `file_add`, `file_remove`, `file_skip`, `file_purge`, `total_files`, `processed_files`) VALUES
	(897, 47, 228, 2, 1, 93, 0, '0.00B', 'a:6:{i:0;s:66:"Connection to https://github.com/craftpip/testrepo.git successful.";s:11:"ftp_connect";s:9:"connected";s:13:"deploy_branch";s:6:"master";s:17:"deploy_branch_env";s:6:"Devdas";s:25:"revision_on_server_before";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:10:"deploy_log";a:44:{i:0;s:19:"Initializing deploy";s:21:"remoteRevision_before";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:5:"files";a:3:{s:6:"upload";i:2;s:6:"delete";i:20;s:4:"skip";i:0;}i:1;s:21:"22 file(s) to process";i:2;s:42:"x removed  1 of 20 New File - Copy (2).txt";i:3;s:42:"x removed  2 of 20 New File - Copy (3).txt";i:4;s:42:"x removed  3 of 20 New File - Copy (4).txt";i:5;s:42:"x removed  4 of 20 New File - Copy (5).txt";i:6;s:42:"x removed  5 of 20 New File - Copy (6).txt";i:7;s:42:"x removed  6 of 20 New File - Copy (7).txt";i:8;s:42:"x removed  7 of 20 New File - Copy (8).txt";i:9;s:42:"x removed  8 of 20 New File - Copy (9).txt";i:10;s:38:"x removed  9 of 20 New File - Copy.txt";i:11;s:31:"x removed 10 of 20 New File.txt";i:12;s:51:"x removed 11 of 20 asdasdas/New File - Copy (7).txt";i:13;s:51:"x removed 12 of 20 asdasdas/New File - Copy (8).txt";i:14;s:51:"x removed 13 of 20 asdasdas/New File - Copy (9).txt";i:15;s:47:"x removed 14 of 20 asdasdas/New File - Copy.txt";i:16;s:40:"x removed 15 of 20 asdasdas/New File.txt";i:17;s:50:"x removed 16 of 20 asdsada/New File - Copy (7).txt";i:18;s:50:"x removed 17 of 20 asdsada/New File - Copy (8).txt";i:19;s:50:"x removed 18 of 20 asdsada/New File - Copy (9).txt";i:20;s:46:"x removed 19 of 20 asdsada/New File - Copy.txt";i:21;s:39:"x removed 20 of 20 asdsada/New File.txt";i:22;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:23;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:24;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:25;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:26;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:27;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:28;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:29;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:30;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:31;s:46:"Ignoring directory "N", reason: doesn\'t exist.";i:32;s:54:"Ignoring directory "asdasdas/", reason: doesn\'t exist.";i:33;s:54:"Ignoring directory "asdasdas/", reason: doesn\'t exist.";i:34;s:54:"Ignoring directory "asdasdas/", reason: doesn\'t exist.";i:35;s:54:"Ignoring directory "asdasdas/", reason: doesn\'t exist.";i:36;s:53:"Ignoring directory "asdsada/", reason: doesn\'t exist.";i:37;s:53:"Ignoring directory "asdsada/", reason: doesn\'t exist.";i:38;s:53:"Ignoring directory "asdsada/", reason: doesn\'t exist.";i:39;s:53:"Ignoring directory "asdsada/", reason: doesn\'t exist.";s:20:"remoteRevision_after";s:40:"21d73f300175c5673082ea1a05891517d7603729";s:8:"deployed";a:2:{s:4:"data";i:0;s:5:"human";s:5:"0.00B";}}}', 1437328015, '', NULL, NULL, '9d9fcb967db09fb979051b1450dc6fdd1c7d7b25', '21d73f300175c5673082ea1a05891517d7603729', NULL, NULL, 2, 20, 0, 0, 22, 22);
INSERT INTO `records` (`id`, `deploy_id`, `user_id`, `record_type`, `status`, `branch_id`, `amount_deployed_raw`, `amount_deployed`, `raw`, `date`, `triggerby`, `post_data`, `avatar_url`, `hash_before`, `hash`, `commit_count`, `commit_message`, `file_add`, `file_remove`, `file_skip`, `file_purge`, `total_files`, `processed_files`) VALUES
	(898, 47, 228, 2, 1, 93, 0, '0.00B', 'a:6:{i:0;s:66:"Connection to https://github.com/craftpip/testrepo.git successful.";s:11:"ftp_connect";s:9:"connected";s:13:"deploy_branch";s:6:"master";s:17:"deploy_branch_env";s:6:"Devdas";s:25:"revision_on_server_before";s:40:"21d73f300175c5673082ea1a05891517d7603729";s:10:"deploy_log";a:10:{i:0;s:19:"Initializing deploy";s:21:"remoteRevision_before";s:40:"21d73f300175c5673082ea1a05891517d7603729";s:5:"files";a:3:{s:6:"upload";i:20;s:6:"delete";i:2;s:4:"skip";i:0;}i:1;s:21:"22 file(s) to process";i:2;s:41:"x removed 1 of 2 newfolder/something2.txt";i:3;s:30:"x removed 2 of 2 something.txt";i:4;s:30:"Created directory \'asdasdas/\'.";i:5;s:29:"Created directory \'asdsada/\'.";s:20:"remoteRevision_after";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:8:"deployed";a:2:{s:4:"data";i:0;s:5:"human";s:5:"0.00B";}}}', 1437328084, '', NULL, NULL, '21d73f300175c5673082ea1a05891517d7603729', '9d9fcb967db09fb979051b1450dc6fdd1c7d7b25', NULL, NULL, 20, 2, 0, 0, 22, 22);
INSERT INTO `records` (`id`, `deploy_id`, `user_id`, `record_type`, `status`, `branch_id`, `amount_deployed_raw`, `amount_deployed`, `raw`, `date`, `triggerby`, `post_data`, `avatar_url`, `hash_before`, `hash`, `commit_count`, `commit_message`, `file_add`, `file_remove`, `file_skip`, `file_purge`, `total_files`, `processed_files`) VALUES
	(899, 47, 228, 2, 1, 93, 0, '0.00B', 'a:6:{i:0;s:66:"Connection to https://github.com/craftpip/testrepo.git successful.";s:11:"ftp_connect";s:9:"connected";s:13:"deploy_branch";s:6:"master";s:17:"deploy_branch_env";s:6:"Devdas";s:25:"revision_on_server_before";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:10:"deploy_log";a:26:{i:0;s:19:"Initializing deploy";s:21:"remoteRevision_before";s:40:"9d9fcb967db09fb979051b1450dc6fdd1c7d7b25";s:5:"files";a:3:{s:6:"upload";i:2;s:6:"delete";i:20;s:4:"skip";i:0;}i:1;s:21:"22 file(s) to process";i:2;s:42:"x removed  1 of 20 New File - Copy (2).txt";i:3;s:42:"x removed  2 of 20 New File - Copy (3).txt";i:4;s:42:"x removed  3 of 20 New File - Copy (4).txt";i:5;s:42:"x removed  4 of 20 New File - Copy (5).txt";i:6;s:42:"x removed  5 of 20 New File - Copy (6).txt";i:7;s:42:"x removed  6 of 20 New File - Copy (7).txt";i:8;s:42:"x removed  7 of 20 New File - Copy (8).txt";i:9;s:42:"x removed  8 of 20 New File - Copy (9).txt";i:10;s:38:"x removed  9 of 20 New File - Copy.txt";i:11;s:31:"x removed 10 of 20 New File.txt";i:12;s:51:"x removed 11 of 20 asdasdas/New File - Copy (7).txt";i:13;s:51:"x removed 12 of 20 asdasdas/New File - Copy (8).txt";i:14;s:51:"x removed 13 of 20 asdasdas/New File - Copy (9).txt";i:15;s:47:"x removed 14 of 20 asdasdas/New File - Copy.txt";i:16;s:40:"x removed 15 of 20 asdasdas/New File.txt";i:17;s:50:"x removed 16 of 20 asdsada/New File - Copy (7).txt";i:18;s:50:"x removed 17 of 20 asdsada/New File - Copy (8).txt";i:19;s:50:"x removed 18 of 20 asdsada/New File - Copy (9).txt";i:20;s:46:"x removed 19 of 20 asdsada/New File - Copy.txt";i:21;s:39:"x removed 20 of 20 asdsada/New File.txt";s:20:"remoteRevision_after";s:40:"21d73f300175c5673082ea1a05891517d7603729";s:8:"deployed";a:2:{s:4:"data";i:0;s:5:"human";s:5:"0.00B";}}}', 1437328088, '', NULL, NULL, '9d9fcb967db09fb979051b1450dc6fdd1c7d7b25', '21d73f300175c5673082ea1a05891517d7603729', NULL, NULL, 2, 20, 0, 0, 22, 22);
/*!40000 ALTER TABLE `records` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.users
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;

-- Dumping data for table craftrzt_gitploy.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `group`, `email`, `last_login`, `login_hash`, `profile_fields`, `created_at`) VALUES
	(228, 'boniface', 'Moympi2IA2w/zrNxrJvDoK/DULtt0hvpHDdl/14dyeo=', 1, 'bonifacepereira@gmail.com', '1437491516', '7e7bb3abf538be52ed0afbb4f5043a478b014236', 'a:3:{s:8:"fullname";s:16:"Boniface pereira";s:5:"phone";s:17:"+1 (555) 123-1212";s:13:"passwordthing";s:5:"asdas";}', 1427962033);
INSERT INTO `users` (`id`, `username`, `password`, `group`, `email`, `last_login`, `login_hash`, `profile_fields`, `created_at`) VALUES
	(230, 'craftpip', 'gSkLFxwkuyFPcFPoqKzYKqqyc02G82Kk1MeKO4HL1Ww=', 1, 'hey@craftpip.com', '1437465954', 'bb5f417cf8983ef4e330b19e51bed122d35467f3', 'a:1:{s:8:"fullname";s:16:"Boniface Pereira";}', 1437465954);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.users_clients
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

-- Dumping data for table craftrzt_gitploy.users_clients: ~0 rows (approximately)
DELETE FROM `users_clients`;
/*!40000 ALTER TABLE `users_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_clients` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.users_providers
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitploy.users_providers: ~1 rows (approximately)
DELETE FROM `users_providers`;
/*!40000 ALTER TABLE `users_providers` DISABLE KEYS */;
INSERT INTO `users_providers` (`id`, `parent_id`, `provider`, `uid`, `secret`, `access_token`, `expires`, `refresh_token`, `user_id`, `created_at`, `updated_at`) VALUES
	(3, 230, 'GitHub', '4782473', NULL, '1b5a405dc00b345ae9dcb65bce80fc101de27ca5', 1437465954, NULL, 0, 1437465954, 0);
/*!40000 ALTER TABLE `users_providers` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.users_scopes
DROP TABLE IF EXISTS `users_scopes`;
CREATE TABLE IF NOT EXISTS `users_scopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scope` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `scope` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table craftrzt_gitploy.users_scopes: ~0 rows (approximately)
DELETE FROM `users_scopes`;
/*!40000 ALTER TABLE `users_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_scopes` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.users_sessions
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

-- Dumping data for table craftrzt_gitploy.users_sessions: ~0 rows (approximately)
DELETE FROM `users_sessions`;
/*!40000 ALTER TABLE `users_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_sessions` ENABLE KEYS */;


-- Dumping structure for table craftrzt_gitploy.users_sessionscopes
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

-- Dumping data for table craftrzt_gitploy.users_sessionscopes: ~0 rows (approximately)
DELETE FROM `users_sessionscopes`;
/*!40000 ALTER TABLE `users_sessionscopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_sessionscopes` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
