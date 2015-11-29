use MY_UNEED_LUNCH;
DROP TABLE IF EXISTS MY_UNEED_LUNCH_STORE;
CREATE TABLE MY_UNEED_LUNCH_STORE ( # �q�K���Ӯa
   RecordID int(11) not null auto_increment primary key, # �Ǹ�
   UserName char(10) not null default '', # �Ӯa�b��
   Password char(21) not null, # �K�X
   StoreName char(40) not null, # �Ӯa�W��
   StoreIntro text not null, # �Ӯa²��
   StoreClass char(4) not null, # �Ӯa���O
   MainMan char(12) not null, # �t�d�H
   Tel char(21) not null, # �q��
   Address char(255) not null default '', # �a�}
   CreateDate int(11) not null, # ���ɤ��
   CreateMan char(12) not null, # ���ɤH��
   EditDate int(11) not null, # ���ʤ��
   EditMan char(12) not null, # ���ʤH��
   Note text not null, # �q�ʻ���
   Status int(11) not null default 0, # ���A, 1:���`, 2:����, 9:�R��
   Index(RecordID)
) type=InnoDB;
