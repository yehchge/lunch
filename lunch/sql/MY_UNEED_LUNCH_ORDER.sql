use MY_UNEED_LUNCH;
DROP TABLE IF EXISTS MY_UNEED_LUNCH_ORDER;
CREATE TABLE MY_UNEED_LUNCH_ORDER ( # �q�K�����
   RecordID int(11) not null auto_increment primary key, # �Ǹ�
   ManagerID int(11) not null default 0, # ���w���a�Ǹ�
   OrderMan Char(255) not null default '', # �q�ʤH
   PdsID int(11) not null default 0, # �ӫ~�Ǹ�
   PdsName char(255) not null default '', # �ӫ~�W��
   Price int(11) not null default 0, # ���B
   Count int(4) not null default 0, # �ƶq
   Note text not null default '', # �q�ʻ���
   CreateDate int(11) not null default 0, # ���ɤ��
   CreateMan char(12) not null default '', # ���ɤH��
   EditDate int(11) not null default 0, # ���ʤ��
   EditMan char(12) not null default '', # ���ʤH��
   Status int(11) not null default 0, # ���A, 1:���`, 2:����, 9:�R��
   Index(RecordID)
) type=InnoDB;
