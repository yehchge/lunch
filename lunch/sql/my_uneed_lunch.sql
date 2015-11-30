-- --------------------------------------------------------
-- 主機:                           localhost
-- 服務器版本:                        5.5.15 - MySQL Community Server (GPL)
-- 服務器操作系統:                      Win32
-- HeidiSQL 版本:                  8.3.0.4775
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 導出 my_uneed_lunch 的資料庫結構
CREATE DATABASE IF NOT EXISTS `my_uneed_lunch` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `my_uneed_lunch`;


-- 導出  表 my_uneed_lunch.my_uneed_lunch_manager 結構
CREATE TABLE IF NOT EXISTS `my_uneed_lunch_manager` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT,
  `StoreID` int(11) NOT NULL,
  `Manager` char(50) NOT NULL DEFAULT '0',
  `Note` text NOT NULL,
  `Status` int(2) NOT NULL DEFAULT '0',
  `CreateDate` int(11) NOT NULL DEFAULT '0',
  `EditDate` int(11) NOT NULL DEFAULT '0',
  `EndDate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RecordID`),
  KEY `RecordID` (`RecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 正在導出表  my_uneed_lunch.my_uneed_lunch_manager 的資料：~0 rows (大約)
DELETE FROM `my_uneed_lunch_manager`;
/*!40000 ALTER TABLE `my_uneed_lunch_manager` DISABLE KEYS */;
/*!40000 ALTER TABLE `my_uneed_lunch_manager` ENABLE KEYS */;


-- 導出  表 my_uneed_lunch.my_uneed_lunch_online 結構
CREATE TABLE IF NOT EXISTS `my_uneed_lunch_online` (
  `OnlineID` int(11) NOT NULL AUTO_INCREMENT,
  `SessionID` char(32) NOT NULL,
  `Account` char(50) NOT NULL,
  `ActiveDate` int(11) NOT NULL,
  `CreateDate` int(11) NOT NULL,
  `RemoteIP` char(16) NOT NULL,
  PRIMARY KEY (`OnlineID`),
  KEY `SessionID` (`SessionID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- 正在導出表  my_uneed_lunch.my_uneed_lunch_online 的資料：~0 rows (大約)
DELETE FROM `my_uneed_lunch_online`;
/*!40000 ALTER TABLE `my_uneed_lunch_online` DISABLE KEYS */;
INSERT INTO `my_uneed_lunch_online` (`OnlineID`, `SessionID`, `Account`, `ActiveDate`, `CreateDate`, `RemoteIP`) VALUES
	(1, '14290e1c786d8784500ef2b7360974db', '1', 1448891992, 1448891496, '::1');
/*!40000 ALTER TABLE `my_uneed_lunch_online` ENABLE KEYS */;


-- 導出  表 my_uneed_lunch.my_uneed_lunch_order 結構
CREATE TABLE IF NOT EXISTS `my_uneed_lunch_order` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT,
  `ManagerID` int(11) NOT NULL DEFAULT '0',
  `OrderMan` char(255) NOT NULL DEFAULT '',
  `PdsID` int(11) NOT NULL DEFAULT '0',
  `PdsName` char(255) NOT NULL DEFAULT '',
  `Price` int(11) NOT NULL DEFAULT '0',
  `Count` int(4) NOT NULL DEFAULT '0',
  `Note` text NOT NULL,
  `CreateDate` int(11) NOT NULL DEFAULT '0',
  `CreateMan` char(12) NOT NULL DEFAULT '',
  `EditDate` int(11) NOT NULL DEFAULT '0',
  `EditMan` char(12) NOT NULL DEFAULT '',
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RecordID`),
  KEY `RecordID` (`RecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 正在導出表  my_uneed_lunch.my_uneed_lunch_order 的資料：~0 rows (大約)
DELETE FROM `my_uneed_lunch_order`;
/*!40000 ALTER TABLE `my_uneed_lunch_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `my_uneed_lunch_order` ENABLE KEYS */;


-- 導出  表 my_uneed_lunch.my_uneed_lunch_product 結構
CREATE TABLE IF NOT EXISTS `my_uneed_lunch_product` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT,
  `StoreID` int(11) NOT NULL,
  `PdsName` char(255) NOT NULL DEFAULT '',
  `PdsType` char(100) NOT NULL DEFAULT '',
  `Price` int(11) NOT NULL,
  `CreateDate` int(11) NOT NULL,
  `CreateMan` char(12) NOT NULL,
  `EditDate` int(11) NOT NULL,
  `EditMan` char(12) NOT NULL,
  `Note` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RecordID`),
  KEY `RecordID` (`RecordID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 正在導出表  my_uneed_lunch.my_uneed_lunch_product 的資料：~0 rows (大約)
DELETE FROM `my_uneed_lunch_product`;
/*!40000 ALTER TABLE `my_uneed_lunch_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `my_uneed_lunch_product` ENABLE KEYS */;


-- 導出  表 my_uneed_lunch.my_uneed_lunch_store 結構
CREATE TABLE IF NOT EXISTS `my_uneed_lunch_store` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` char(10) NOT NULL DEFAULT '',
  `Password` char(21) NOT NULL,
  `StoreName` char(40) NOT NULL,
  `StoreIntro` text NOT NULL,
  `StoreClass` char(4) NOT NULL,
  `MainMan` char(12) NOT NULL,
  `Tel` char(21) NOT NULL,
  `Address` char(255) NOT NULL DEFAULT '',
  `CreateDate` int(11) NOT NULL,
  `CreateMan` char(12) NOT NULL,
  `EditDate` int(11) NOT NULL,
  `EditMan` char(12) NOT NULL,
  `Note` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RecordID`),
  KEY `RecordID` (`RecordID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- 正在導出表  my_uneed_lunch.my_uneed_lunch_store 的資料：~2 rows (大約)
DELETE FROM `my_uneed_lunch_store`;
/*!40000 ALTER TABLE `my_uneed_lunch_store` DISABLE KEYS */;
INSERT INTO `my_uneed_lunch_store` (`RecordID`, `UserName`, `Password`, `StoreName`, `StoreIntro`, `StoreClass`, `MainMan`, `Tel`, `Address`, `CreateDate`, `CreateMan`, `EditDate`, `EditMan`, `Note`, `Status`) VALUES
	(7, '', '', '商家名稱', '簡介 ', '便當', '老闆', '02-66007079', '台北市內湖區內湖路91巷17號3樓', 1448891447, '1', 1448891447, '', '訂購說明 ', 1),
	(8, '', '', '商家名稱', '簡介 ', '便當', '老闆', '02-66007079', '台北市內湖區內湖路91巷17號3樓', 1448891450, '1', 1448891450, '', '訂購說明 ', 1);
/*!40000 ALTER TABLE `my_uneed_lunch_store` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
