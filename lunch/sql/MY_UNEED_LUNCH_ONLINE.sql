use MY_UNEED_LUNCH;
DROP TABLE IF EXISTS MY_UNEED_LUNCH_ONLINE;
CREATE TABLE MY_UNEED_LUNCH_ONLINE ( # 訂便當線上紀錄
   OnlineID int(11) not null auto_increment primary key, # 序號
   SessionID char(32) not null, # SessionID 
   Account char(50) not null, # UMS.USER_INFO.Account 使用者帳號 FK
   ActiveDate int(11) not null, # 在線時間
   CreateDate int(11) not null, # 建立時間
   RemoteIP char(16) not null, # 廠商IP位置
   Index(SessionID)
) ENGINE=InnoDB;