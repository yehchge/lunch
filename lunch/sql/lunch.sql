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

-- 導出 lunch 的資料庫結構
CREATE DATABASE IF NOT EXISTS `lunch` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `lunch`;


-- 導出  表 lunch.lunch_manager 結構
CREATE TABLE IF NOT EXISTS `lunch_manager` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT COMMENT '序號',
  `StoreID` int(11) NOT NULL COMMENT '店家序號',
  `Manager` char(50) NOT NULL DEFAULT '0' COMMENT '負責人',
  `Note` text NOT NULL COMMENT '說明',
  `Status` int(2) NOT NULL DEFAULT '0' COMMENT '狀態 1:訂購中, 2:截止訂購, 3:取消, 9:刪除',
  `CreateDate` int(11) NOT NULL DEFAULT '0' COMMENT '建立日期',
  `EditDate` int(11) NOT NULL DEFAULT '0' COMMENT '修改日期',
  `EndDate` int(11) NOT NULL DEFAULT '0' COMMENT '截止日期',
  PRIMARY KEY (`RecordID`),
  KEY `RecordID` (`RecordID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='訂便當負責人主檔';

-- 正在導出表  lunch.lunch_manager 的資料：0 rows
DELETE FROM `lunch_manager`;
/*!40000 ALTER TABLE `lunch_manager` DISABLE KEYS */;
/*!40000 ALTER TABLE `lunch_manager` ENABLE KEYS */;


-- 導出  表 lunch.lunch_online 結構
CREATE TABLE IF NOT EXISTS `lunch_online` (
  `OnlineID` int(11) NOT NULL AUTO_INCREMENT COMMENT '序號',
  `SessionID` char(32) NOT NULL COMMENT 'SessionID',
  `Account` char(50) NOT NULL COMMENT 'Account 使用者帳號 FK',
  `ActiveDate` int(11) NOT NULL COMMENT '在線時間',
  `CreateDate` int(11) NOT NULL COMMENT '建立時間',
  `RemoteIP` char(16) NOT NULL COMMENT 'IP位置',
  PRIMARY KEY (`OnlineID`),
  KEY `SessionID` (`SessionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='訂便當線上紀錄';

-- 正在導出表  lunch.lunch_online 的資料：0 rows
DELETE FROM `lunch_online`;
/*!40000 ALTER TABLE `lunch_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `lunch_online` ENABLE KEYS */;


-- 導出  表 lunch.lunch_order 結構
CREATE TABLE IF NOT EXISTS `lunch_order` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT COMMENT '序號',
  `ManagerID` int(11) NOT NULL DEFAULT '0' COMMENT '指定店家序號',
  `OrderMan` char(255) NOT NULL DEFAULT '' COMMENT '訂購人',
  `PdsID` int(11) NOT NULL DEFAULT '0' COMMENT '商品序號',
  `PdsName` char(255) NOT NULL DEFAULT '' COMMENT '商品名稱',
  `Price` int(11) NOT NULL DEFAULT '0' COMMENT '金額',
  `Count` int(4) NOT NULL DEFAULT '0' COMMENT '數量',
  `Note` text NOT NULL COMMENT '訂購說明',
  `CreateDate` int(11) NOT NULL DEFAULT '0' COMMENT '建檔日期',
  `CreateMan` char(12) NOT NULL DEFAULT '' COMMENT '建檔人員',
  `EditDate` int(11) NOT NULL DEFAULT '0' COMMENT '異動日期',
  `EditMan` char(12) NOT NULL DEFAULT '' COMMENT '異動人員',
  `Status` int(11) NOT NULL DEFAULT '0' COMMENT '狀態, 1:正常, 2:取消, 9:刪除',
  PRIMARY KEY (`RecordID`),
  KEY `RecordID` (`RecordID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='訂便當明細';

-- 正在導出表  lunch.lunch_order 的資料：0 rows
DELETE FROM `lunch_order`;
/*!40000 ALTER TABLE `lunch_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `lunch_order` ENABLE KEYS */;


-- 導出  表 lunch.lunch_product 結構
CREATE TABLE IF NOT EXISTS `lunch_product` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT COMMENT '序號',
  `StoreID` int(11) NOT NULL COMMENT '店家序號',
  `PdsName` char(255) NOT NULL DEFAULT '' COMMENT '商品名稱',
  `PdsType` char(100) NOT NULL DEFAULT '' COMMENT '商品型別,例如 大,小,中',
  `Price` int(11) NOT NULL COMMENT '金額',
  `CreateDate` int(11) NOT NULL COMMENT '建檔日期',
  `CreateMan` char(12) NOT NULL COMMENT '建檔人員',
  `EditDate` int(11) NOT NULL COMMENT '異動日期',
  `EditMan` char(12) NOT NULL COMMENT '異動人員',
  `Note` text NOT NULL COMMENT '商品名稱說明註解',
  `Status` int(11) NOT NULL DEFAULT '0' COMMENT '態, 1:正常, 2:停用, 9:刪除',
  PRIMARY KEY (`RecordID`),
  KEY `RecordID` (`RecordID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='訂便當的明細';

-- 正在導出表  lunch.lunch_product 的資料：0 rows
DELETE FROM `lunch_product`;
/*!40000 ALTER TABLE `lunch_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `lunch_product` ENABLE KEYS */;


-- 導出  表 lunch.lunch_store 結構
CREATE TABLE IF NOT EXISTS `lunch_store` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT COMMENT '序號',
  `UserName` char(10) NOT NULL DEFAULT '' COMMENT '商家帳號',
  `Password` char(21) NOT NULL COMMENT '密碼',
  `StoreName` char(40) NOT NULL COMMENT '商家名稱',
  `StoreIntro` text NOT NULL COMMENT '商家簡介',
  `StoreClass` char(4) NOT NULL COMMENT '商家類別',
  `MainMan` char(12) NOT NULL COMMENT '負責人',
  `Tel` char(21) NOT NULL COMMENT '電話',
  `Address` char(255) NOT NULL DEFAULT '' COMMENT '地址',
  `CreateDate` int(11) NOT NULL COMMENT '建檔日期',
  `CreateMan` char(12) NOT NULL COMMENT '建檔人員',
  `EditDate` int(11) NOT NULL COMMENT '異動日期',
  `EditMan` char(12) NOT NULL COMMENT '異動人員',
  `Note` text NOT NULL COMMENT '訂購說明',
  `Status` int(11) NOT NULL DEFAULT '0' COMMENT '狀態, 1:正常, 2:停用, 9:刪除',
  PRIMARY KEY (`RecordID`),
  KEY `RecordID` (`RecordID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='訂便當的商家';

-- 正在導出表  lunch.lunch_store 的資料：0 rows
DELETE FROM `lunch_store`;
/*!40000 ALTER TABLE `lunch_store` DISABLE KEYS */;
/*!40000 ALTER TABLE `lunch_store` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
