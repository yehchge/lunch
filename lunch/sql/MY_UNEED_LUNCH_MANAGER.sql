use MY_UNEED_LUNCH;
drop table if exists MY_UNEED_LUNCH_MANAGER;
create table MY_UNEED_LUNCH_MANAGER( # �q�K��t�d�H�D��
   RecordID int(11) not null auto_increment primary key, # �Ǹ�
   StoreID int(11) not null, # ���a�Ǹ� 
   Manager char(50) not null default 0, # �t�d�H
   Note text not null , # ���� 
   Status int(2) not null default 0, # ���A 1:�q�ʤ�, 2:�I��q��, 3:����, 9:�R��
   CreateDate int(11) not null default 0, # �إߤ��
   EditDate int(11) not null default 0, # �ק���
   EndDate int(11) not null default 0, # �I����
   Index(RecordID)
) ENGINE=InnoDB;
