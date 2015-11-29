use MY_UNEED_LUNCH;
DROP TABLE IF EXISTS MY_UNEED_LUNCH_PRODUCT;
CREATE TABLE MY_UNEED_LUNCH_PRODUCT ( # �q�K������
   RecordID int(11) not null auto_increment primary key, # �Ǹ�
   StoreID int(11) not null, # ���a�Ǹ� 
   PdsName char(255) not null default '', # �ӫ~�W��
   PdsType char(100) not null default '', # �ӫ~���O,�Ҧp �j,�p,��
   Price int(11) not null, # ���B
   CreateDate int(11) not null, # ���ɤ��
   CreateMan char(12) not null, # ���ɤH��
   EditDate int(11) not null, # ���ʤ��
   EditMan char(12) not null, # ���ʤH��
   Note text not null, # �ӫ~�W�ٻ�������
   Status int(11) not null default 0, # ���A, 1:���`, 2:����, 9:�R��
   Index(RecordID)
) type=InnoDB;
