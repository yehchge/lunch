use MY_UNEED_LUNCH;
DROP TABLE IF EXISTS MY_UNEED_LUNCH_PRODUCT;
CREATE TABLE MY_UNEED_LUNCH_PRODUCT ( # 訂便當的明細
   RecordID int(11) not null auto_increment primary key, # 序號
   StoreID int(11) not null, # 店家序號 
   PdsName char(255) not null default '', # 商品名稱
   PdsType char(100) not null default '', # 商品型別,例如 大,小,中
   Price int(11) not null, # 金額
   CreateDate int(11) not null, # 建檔日期
   CreateMan char(12) not null, # 建檔人員
   EditDate int(11) not null, # 異動日期
   EditMan char(12) not null, # 異動人員
   Note text not null, # 商品名稱說明註解
   Status int(11) not null default 0, # 狀態, 1:正常, 2:停用, 9:刪除
   Index(RecordID)
) type=InnoDB;
