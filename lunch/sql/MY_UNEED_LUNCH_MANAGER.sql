use MY_UNEED_LUNCH;
drop table if exists MY_UNEED_LUNCH_MANAGER;
create table MY_UNEED_LUNCH_MANAGER( # 訂便當負責人主檔
   RecordID int(11) not null auto_increment primary key, # 序號
   StoreID int(11) not null, # 店家序號 
   Manager char(50) not null default 0, # 負責人
   Note text not null , # 說明 
   Status int(2) not null default 0, # 狀態 1:訂購中, 2:截止訂購, 3:取消, 9:刪除
   CreateDate int(11) not null default 0, # 建立日期
   EditDate int(11) not null default 0, # 修改日期
   EndDate int(11) not null default 0, # 截止日期
   Index(RecordID)
) ENGINE=InnoDB;
