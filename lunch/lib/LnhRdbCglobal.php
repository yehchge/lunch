<?php

/****c LIB/LnhRdbCglobal
 *   NAME
 *      LnhRdbCglobal
 *   COPYRIGHT
 *   FUNCTION
 *      訂便當管理程式
 *   AUTHOR
 *   SEE ALSO
 *      n/a
 *   MODIFICATION HISTORY
 *      11/21/2006	1.0     Creater
 ****
 */
   class LnhRdbCglobal{
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
      Public $MY_UNEED_TITLE;
           

/****m LIB/LnhRdbCglobal
 *  NAME 
 * 	   LnhRdbCglobal
 *  SYNOPSIS
 *	   LnhRdbCglobal
 *  FUNCTION
 *      訂便當管理程式用變數
 *  INPUTS
 *      n/a
 *  OUTPUT
 *	    n/a
 *  AUTHOR
 ****
 */   
      function LnhRdbCglobal(){
         $this->MY_SQL_SERVER=1;
         $this->OR_SQL_SERVER=2;
         //$this->MY_SQL_UID="root";
         //$this->MY_SQL_PWD="mamamiya";
         $this->MY_SQL_UID="robot";
         $this->MY_SQL_PWD="robot";
         $this->MY_SQL_HOST="localhost";
         $this->MY_SQL_DB_LUNCH="LUNCH";
         $this->MY_SQL_TABLE_LUNCH_STORE="LUNCH_STORE";
		 $this->MY_SQL_TABLE_LUNCH_PRODUCT="LUNCH_PRODUCT";
         $this->MY_SQL_TABLE_LUNCH_MANAGER="LUNCH_MANAGER";
		 $this->MY_SQL_TABLE_LUNCH_ORDER="LUNCH_ORDER";
		 $this->MY_SQL_TABLE_LUNCH_ONLINE="LUNCH_ONLINE";
		 $this->MY_TITLE="訂便當系統";
      } 
   }
?>