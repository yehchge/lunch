use MY_UNEED_LUNCH;
DROP TABLE IF EXISTS MY_UNEED_LUNCH_ONLINE;
CREATE TABLE MY_UNEED_LUNCH_ONLINE ( # �q�K��u�W����
   OnlineID int(11) not null auto_increment primary key, # �Ǹ�
   SessionID char(32) not null, # SessionID 
   Account char(50) not null, # UMS.USER_INFO.Account �ϥΪ̱b�� FK
   ActiveDate int(11) not null, # �b�u�ɶ�
   CreateDate int(11) not null, # �إ߮ɶ�
   RemoteIP char(16) not null, # �t��IP��m
   Index(SessionID)
) ENGINE=InnoDB;