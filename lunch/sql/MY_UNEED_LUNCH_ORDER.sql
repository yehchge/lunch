use MY_UNEED_LUNCH;
DROP TABLE IF EXISTS MY_UNEED_LUNCH_ORDER;
CREATE TABLE MY_UNEED_LUNCH_ORDER ( # 訂便當明細
   RecordID int(11) not null auto_increment primary key, # 序號
   ManagerID int(11) not null default 0, # 指定店家序號
   OrderMan Char(255) not null default '', # 訂購人
   PdsID int(11) not null default 0, # 商品序號
   PdsName char(255) not null default '', # 商品名稱
   Price int(11) not null default 0, # 金額
   Count int(4) not null default 0, # 數量
   Note text not null default '', # 訂購說明
   CreateDate int(11) not null default 0, # 建檔日期
   CreateMan char(12) not null default '', # 建檔人員
   EditDate int(11) not null default 0, # 異動日期
   EditMan char(12) not null default '', # 異動人員
   Status int(11) not null default 0, # 狀態, 1:正常, 2:取消, 9:刪除
   Index(RecordID)
) type=InnoDB;
