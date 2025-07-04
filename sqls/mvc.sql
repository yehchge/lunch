-- --------------------------------------------------------
-- 主機:                           127.0.0.1
-- 服務器版本:                        10.2.15-MariaDB-10.2.15+maria~xenial - mariadb.org binary distribution
-- 服務器操作系統:                      debian-linux-gnu
-- HeidiSQL 版本:                  9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 導出 mvc2 的資料庫結構
-- CREATE DATABASE IF NOT EXISTS `mvc2` !40100 DEFAULT CHARACTER SET utf8mb4 ;
-- USE `mvc2`;


-- 導出  表 mvc2.data 結構
CREATE TABLE IF NOT EXISTS `data` (
  `dataid` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`dataid`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4;

-- 正在導出表  mvc2.data 的資料：10 rows
/*!40000 ALTER TABLE `data` DISABLE KEYS */;
INSERT INTO `data` (`dataid`, `text`) VALUES
	(36, 'test1'),
	(37, 'test2'),
	(38, 'test3'),
	(39, 'test4'),
	(40, 'test5'),
	(41, 'test6'),
	(42, 'test7'),
	(43, 'test8'),
	(44, 'test9'),
	(49, '測試');
/*!40000 ALTER TABLE `data` ENABLE KEYS */;


-- 導出  表 mvc2.note 結構
CREATE TABLE IF NOT EXISTS `note` (
  `noteid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`noteid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- 正在導出表  mvc2.note 的資料：4 rows
/*!40000 ALTER TABLE `note` DISABLE KEYS */;
INSERT INTO `note` (`noteid`, `title`, `userid`, `content`, `date_added`) VALUES
	(1, 'Jesse', 8, 'This is a note.', '0000-00-00 00:00:00'),
	(13, 'Jesse2', 34, 'Jesse2 message.', '2018-06-17 00:13:01'),
	(8, 'DOG FACE', 34, '111', '2013-10-17 19:31:08'),
	(10, 'Merry', 8, '這是一個測試', '2018-06-16 16:57:00');
/*!40000 ALTER TABLE `note` ENABLE KEYS */;


-- 導出  表 mvc2.person 結構
CREATE TABLE IF NOT EXISTS `person` (
  `name` varchar(50) NOT NULL,
  `personid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `age` int(3) unsigned NOT NULL,
  `gender` varchar(1) NOT NULL,
  PRIMARY KEY (`personid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- 正在導出表  mvc2.person 的資料：3 rows
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` (`name`, `personid`, `age`, `gender`) VALUES
	('JESSE', 1, 24, 'm'),
	('joe', 2, 22, 'm'),
	('jenny', 3, 434, 'f');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;


-- 導出  表 mvc2.mvc_user 結構
CREATE TABLE IF NOT EXISTS `mvc_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` enum('default','admin','owner') NOT NULL DEFAULT 'default',
  `login_session` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

-- 正在導出表  mvc2.mvc_user 的資料：5 rows
/*!40000 ALTER TABLE `mvc_user` DISABLE KEYS */;
INSERT INTO `mvc_user` (`userid`, `login`, `password`, `role`, `login_session`) VALUES
	(7, 'test12', '09c78f479e758519ce90d69ddc19c3e4', 'owner', ''),
	(8, 'demo', '88f2dccb02b2a20615211e5492f85204', 'owner', '34229989384a4cb26ca5c0b3bdba4ae8'),
	(34, 'jesse2', '8aa8c12fd71338d4ed652ffe41cdb792', 'default', '603e08b1a82f160ae9012afb9be5c33c'),
	(35, 'test33', '37017ef30e2adb8e9de2846a03e6caa1', 'default', '');
/*!40000 ALTER TABLE `mvc_user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
