<?php

declare(strict_types=1); // 嚴格類型


class LnhRdbCglobal {
   Public $MY_SQL_SERVER;
   Public $OR_SQL_SERVER;
   Public $MY_SQL_UID;
   Public $MY_SQL_PWD;
   Public $MY_SQL_HOST;
   Public $MY_SQL_DB_LUNCH;
   Public $MY_SQL_TABLE_LUNCH_STORE;
   Public $MY_SQL_TABLE_LUNCH_PRODUCT;
   Public $MY_SQL_TABLE_LUNCH_MANAGER;
	Public $MY_SQL_TABLE_LUNCH_ORDER;
	Public $MY_SQL_TABLE_LUNCH_ONLINE;
   Public $MY_TITLE;
   Public $DbType;
           
 
   public function __construct(){
      $this->DbType = 1;
      $this->MY_SQL_SERVER=1;
      $this->OR_SQL_SERVER=2;
      //$this->MY_SQL_UID="root";
      //$this->MY_SQL_PWD="mamamiya";
      $this->MY_SQL_UID = getenv("DATABASE_USER");
      $this->MY_SQL_PWD = getenv("DATABASE_PASS");
      $this->MY_SQL_HOST = getenv("DATABASE_HOST");
      $this->MY_SQL_DB_LUNCH = getenv("DATABASE_NAME");
      $this->MY_SQL_TABLE_LUNCH_STORE="lunch_store";
		$this->MY_SQL_TABLE_LUNCH_PRODUCT="lunch_product";
      $this->MY_SQL_TABLE_LUNCH_MANAGER="lunch_manager";
		$this->MY_SQL_TABLE_LUNCH_ORDER="lunch_order";
		$this->MY_SQL_TABLE_LUNCH_ONLINE="lunch_online";
		$this->MY_TITLE="DinBenDon系統";
   } 
}
