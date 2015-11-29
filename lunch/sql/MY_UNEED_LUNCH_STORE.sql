use MY_UNEED_LUNCH;
DROP TABLE IF EXISTS MY_UNEED_LUNCH_STORE;
CREATE TABLE MY_UNEED_LUNCH_STORE ( # 訂便當的商家
   RecordID int(11) not null auto_increment primary key, # 序號
   UserName char(10) not null default '', # 商家帳號
   Password char(21) not null, # 密碼
   StoreName char(40) not null, # 商家名稱
   StoreIntro text not null, # 商家簡介
   StoreClass char(4) not null, # 商家類別
   MainMan char(12) not null, # 負責人
   Tel char(21) not null, # 電話
   Address char(255) not null default '', # 地址
   CreateDate int(11) not null, # 建檔日期
   CreateMan char(12) not null, # 建檔人員
   EditDate int(11) not null, # 異動日期
   EditMan char(12) not null, # 異動人員
   Note text not null, # 訂購說明
   Status int(11) not null default 0, # 狀態, 1:正常, 2:停用, 9:刪除
   Index(RecordID)
) type=InnoDB;
