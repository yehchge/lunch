<?php

/****c lib/LnhLnhCfactory [1.0]
 *
 *   NAME
 *      LnhLnhCfactory.php  --
 *   COPYRIGHT
 *      UNEED
 *   AUTHOR
 *      Bill Yeh
 *   MODIFICATION HISTORY
 *      11/21/2006      1.0     Creater
 ****
 */
 include_once PATH_ROOT."/lunch/gphplib/SysRdbCconnection.php";
 include_once PATH_ROOT."/lunch/lib/LnhRdbCglobal.php";
 //include_once PATH_ROOT."/ums/lib/UmsUmsCfactory.php";

 class LnhLnhCfactory extends SysRdbCconnection{

    public $LnhDBH;
    public $LnhValriables;
    var $file = "/usr/local/apache2/htdocs/adm/lib/system.ini.php";
	var $SecretWord="ieatlunch";
    
    //public $SecretWord;

    /****m lib/LnhLnhCfactory->LnhLnhCfactory
     *   NAME
     *      LnhLnhCfactory
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      construct
     ****
     */
     public function __construct () {
         $this->LnhVariable = new LnhRdbCglobal();
         $this->LnhDBH = new SysRdbCconnection(NULL,NULL,$this->LnhVariable->MY_SQL_UID,$this->LnhVariable->MY_SQL_PWD,NULL,$this->LnhVariable->MY_SQL_HOST,$this->LnhVariable->MY_SQL_SERVER);         
          $this->LnhDBH->activate();
     }

     public function getLastInsertID($table='') {
		 if(!$table)  $table=$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE;
         if ($row = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$table,"LAST_INSERT_ID()","1=1")))
              {
                 return $row[0];
              }
           return 0;
     } 
     
    /****m lib/LnhLnhCfactory->CreateStore
     *   NAME
     *      CreateStore
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      新增商家
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function CreateStore($UserName='',$Password='',$StoreName='',$StoreIntro='',$StoreClass='',$MainMan='',$Tel='',$Address='',$CreateMan='',$Note='') {
        if (!$StoreName or !$StoreIntro or !$StoreClass or !$MainMan or !$Tel or !$Address or !$CreateMan or !$Note) return 0;
     	$tt = time();
     	$fileds = "UserName,Password,StoreName,StoreIntro,StoreClass,MainMan,Tel,Address,CreateDate,CreateMan,EditDate,EditMan,Note,Status";
     	$values = "'$UserName ','$Password ','$StoreName ','$StoreIntro ','$StoreClass ','$MainMan ','$Tel ','$Address ',$tt,'$CreateMan ',$tt,'','$Note ',1";
      	if ($this->LnhDBH->SqlInsert($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE,$fileds,$values)) {
			return $this->getLastInsertID($this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE);	
	    }
		//echo mysql_error()."<br>";
		//echo $this->LnhDBH->SqlStm;
      	return 0;                  
     }
    
    /****m lib/LnhLnhCfactory->UpdateStore
     *   NAME
     *      UpdateStore
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      更新商家
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function UpdateStore($RecordID=0,$UserName='',$Password='',$StoreName='',$StoreIntro='',$StoreClass='',$MainMan='',$Tel='',$Address='',$EditMan='',$Note='',$Status=0) {
         if(!$RecordID) return 0;
     	 $tt = time();
     	 $values  = "UserName='$UserName ',";
     	 $values .= "Password='$Password ',";
		 $values .= "StoreName='$StoreName ',";
		 $values .= "StoreIntro='$StoreIntro ',";
		 $values .= "StoreClass='$StoreClass ',";
         $values .= "MainMan='$MainMan ',";
         $values .= "Tel='$Tel ',";
         $values .= "Address='$Address ',";
         $values .= "EditMan='$EditMan ',";
         $values .= "EditDate=$tt,";
         $values .= "Note='$Note ',";
         $values .= "Status=$Status";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE, $values ,$condition);
     	 //echo $this->LnhDBH->SqlStm;
		 if($tmp) return 1;
		 
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetAllStore
     *   NAME
     *      GetAllStore
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取商家全部資料
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function GetAllStore() {
     	 $fileds = "*";
         if ($rows = $this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE,$fileds,"1=1"))
              {
                 return $rows;
              }
          return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetStoreDetailsByRecordID
     *   NAME
     *      GetStoreDetailsByRecordID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取一筆商家詳細資料
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetStoreDetailsByRecordID($RecordID=0) {
     	if(!$RecordID) return 0;
     	$fileds = "*";
     	$condition = "RecordID=$RecordID";
     	if ($row = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE,$fileds,$condition))) {
			//echo $this->LnhDBH->SqlStm;
     	    return $row;
     	} 
     	return 0;
     }
    
    /****m lib/LnhLnhCfactory->GetAllStorePage
     *   NAME
     *      GetAllStorePage
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取商家分頁全部資料
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function GetAllStorePage($Status=0,$Name='',$PayType=0,$startRow=0,$maxRows=10) {
     	 $values = "*";
         $condition = "1=1";
         if($Status) $condition.= " and Status=$Status";
         if($Name) $condition .= " and Name like '%$Name''";
         if($PayType) $condition .= " and PayType=$PayType";
         $condition .= " order by CreateDate Desc ";
		 //$condition = "SupplyID=$SupplyID";
         if ($rows = $this->LnhDBH->SqlDataPageSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE,$values,$condition,$startRow,$maxRows)) {
			//echo $this->LnhDBH->SqlStm;exit();
       		return $rows;
         }
         return 0;
     }
     
    /****m lib/LnhLnhCfactory->GetAllStoreCount
     *   NAME
     *      GetAllStoreCount
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取所有商家全部總數
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetAllStoreCount($Status=0) {
		$fileds = "count(*)";
		$condition = "1=1";
		if($Status) $condition.= " and Status=$Status";
        if ($rows = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE,$fileds,$condition))) {
			return $rows[0];
        }
        return 0;
     }

    /****m lib/LnhLnhCfactory->CreateProduct
     *   NAME
     *      CreateProduct
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      新增便當商品
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function CreateProduct($StoreID=0,$PdsName='',$PdsType='',$Price=0,$CreateMan='',$Note='') {
		if (!$StoreID or !$PdsName or !$Price or !$CreateMan) return 0;
		$tt = time();
		$fileds = "StoreID,PdsName,PdsType,Price,CreateMan,Note,Status,CreateDate,EditDate,EditMan";
		$values = "$StoreID,'$PdsName ','$PdsType ',$Price,'$CreateMan ','$Note ',1,$tt,$tt,''";
		if ($this->LnhDBH->SqlInsert($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT,$fileds,$values)) {
			return $this->getLastInsertID($this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT);	
		}
		//echo $this->LnhDBH->SqlStm;
		return 0;                  
	 }

    /****m lib/LnhLnhCfactory->UpdateProduct
     *   NAME
     *      UpdateProduct
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      更新便當商品
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function UpdateProduct($RecordID=0,$StoreID=0,$PdsName='',$PdsType='',$Price=0,$EditMan='',$Note='',$Status=0) {
		 if(!$RecordID) return 0;
     	 $tt = time();
     	 $values  = "StoreID=$StoreID,PdsName='$PdsName ',PdsType='$PdsType ',Price=$Price,";
         $values .= "EditMan='$EditMan ',EditDate=$tt,Note='$Note ',Status=$Status";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT, $values ,$condition);
     	 if($tmp) return 1;
		 echo $this->LnhDBH->SqlStm;
         return 0;
     }

    /****m lib/LnhLnhCfactory->GetPdsDetailsByRecordID
     *   NAME
     *      GetPdsDetailsByRecordID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取一筆便當明細資料
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetPdsDetailsByRecordID($RecordID=0) {
     	if(!$RecordID) return 0;
     	
     	$fileds = "*";
     	$condition = "RecordID=$RecordID";
     	if ($row = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT,$fileds,$condition))) {
			//echo $this->LnhDBH->SqlStm;
     	    return $row;
     	} 
     	return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetAllProductByStore
     *   NAME
     *      GetAllProductByStore
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取商家便當商品全部資料
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function GetAllProductByStore($StoreID=0) {
		 if (!$StoreID) return 0;
     	 $fileds = "*";
		 $condition = "StoreID=$StoreID";
         if ($rows = $this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT,$fileds,$condition)) {
			return $rows;
         }
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetAllPdsPageByStore
     *   NAME
     *      GetAllPdsPageByStore
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取商家便當明細分頁全部資料
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function GetAllPdsPageByStore($StoreID=0,$Status=0,$PayType=0,$startRow=0,$maxRows=10) {
		 if (!$StoreID) return 0;
     	 $values = "*";
         $condition = "1=1";
         if($StoreID) $condition.= " and StoreID=$StoreID";
         if($Status) $condition .= " and Status=$Status";
         if($PayType) $condition .= " and PayType=$PayType";
         $condition .= " order by CreateDate Desc ";
		 //$condition = "SupplyID=$SupplyID";
         if ($rows = $this->LnhDBH->SqlDataPageSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT,$values,$condition,$startRow,$maxRows)) {
			//echo $this->LnhDBH->SqlStm;exit();
       		return $rows;
         }
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetAllPdsCountByStore
     *   NAME
     *      GetAllPdsCountByStore
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取單一商家商品全部總數
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetAllPdsCountByStore($StoreID=0,$Status=0) {
		if (!$StoreID) return 0;
		$fileds = "count(*)";
		$condition = "StoreID=$StoreID";
		if ($Status) $condition .= " and Status=$Status";
        if ($rows = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT,$fileds,$condition))) {
			return $rows[0];
        }
        return 0;
     }

    /****m lib/LnhLnhCfactory->CreateManager
     *   NAME
     *      CreateManager
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      新增當日訂單管理
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function CreateManager($StoreID=0,$Manager='',$Note='',$EndDate=0) {
        if (!$StoreID or !$Manager or !$Note) return 0;
		$tt = time();
		$fileds = "StoreID,Manager,Note,Status,CreateDate,EditDate,EndDate";
		$values = "$StoreID,'$Manager ','$Note ',1,$tt,$tt,$EndDate";
		if ($this->LnhDBH->SqlInsert($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER,$fileds,$values)) {
			return $this->getLastInsertID($this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER);	
		}
		//return $this->LnhDBH->SqlStm;
		return 0;                  
	 }

    /****m lib/LnhLnhCfactory->UpdateManager
     *   NAME
     *      UpdateManager
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      更新當日訂單管理
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function UpdateManager($RecordID=0,$StoreID=0,$Manager='',$Note='',$Status=0,$EndDate='') {
         if(!$RecordID) return 0;
     	 $tt = time();
     	 $values  = "StoreID=$StoreID,Manager='$Manager',Note='$Note',Status=$Status,";
         $values .= "EditDate=$tt,EndDate='$EndDate'";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER, $values ,$condition);
     	 if($tmp) return 1;
		 //	echo $this->LnhDBH->SqlStm;
         return 0;
     }

    /****m lib/LnhLnhCfactory->UpdateManagerStatusByRecordID
     *   NAME
     *      UpdateManagerStatusByRecordID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      更新當日訂單管理
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function UpdateManagerStatusByRecordID($RecordID=0,$Status=0) {
         if(!$RecordID or !$Status) return 0;
     	 $tt = time();
     	 $values  = "Status=$Status,EditDate=$tt";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER, $values ,$condition);
     	 if($tmp) return 1;
		 //	echo $this->LnhDBH->SqlStm;
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetManagerDetailsByRecordID
     *   NAME
     *      GetManagerDetailsByRecordID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取一筆指定店家明細資料
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetManagerDetailsByRecordID($RecordID=0) {
     	if(!$RecordID) return 0;
     	
     	$fileds = "*";
     	$condition = "RecordID=$RecordID";
     	if ($row = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER,$fileds,$condition))) {
			//echo $this->LnhDBH->SqlStm;
     	    return $row;
     	} 
     	return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetAllManagerPage
     *   NAME
     *      GetAllManagerPage
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取指定商家明細分頁全部資料
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function GetAllManagerPage($Status=0,$PayType=0,$startRow=0,$maxRows=10) {
     	 $values = "*";
		 $DateString = date("Ymd",mktime(0, 0, 0,date("m"),date("d"),date("Y")));
         $condition = "Status!=9 and CreateDate>=unix_timestamp('$DateString')";
		 // (CONVERT(char(8), a.TRX_DATE, 112) 
         if($Status) $condition .= " and Status=$Status";
         if($PayType) $condition .= " and PayType=$PayType";
         $condition .= " order by CreateDate Desc ";
		 //$condition = "SupplyID=$SupplyID";
         if ($rows = $this->LnhDBH->SqlDataPageSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER,$values,$condition,$startRow,$maxRows)) {
			//echo $this->LnhDBH->SqlStm;exit();
       		return $rows;
         }
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetActiveManagerPage
     *   NAME
     *      GetActiveManagerPage
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取有效指定商家明細分頁全部資料
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function GetActiveManagerPage($Status=0,$PayType=0,$startRow=0,$maxRows=10) {
     	 $values = "*";
         $condition = "Status in (1,2)";
         $condition .= " order by CreateDate Desc ";
		 //$condition = "SupplyID=$SupplyID";
         if ($rows = $this->LnhDBH->SqlDataPageSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER,$values,$condition,$startRow,$maxRows)) {
			//echo $this->LnhDBH->SqlStm;exit();
       		return $rows;
         }
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetActiveManagerPageCount
     *   NAME
     *      GetActiveManagerPageCount
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取有效指定商家明細全部總數
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetActiveManagerPageCount() {
		$fileds = "count(*)";
		$condition = "Status in (1,2)";
        if ($rows = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER,$fileds,$condition))) {
			return $rows[0];
        }
        return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetAllManagerCount
     *   NAME
     *      GetAllManagerCount
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取指定商家明細全部總數
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetAllManagerCount($Status=0) {
		$fileds = "count(*)";
		$condition = "1=1 and Status!=9";
		if ($Status) $condition .= " and Status=$Status";
        if ($rows = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER,$fileds,$condition))) {
			return $rows[0];
        }
        return 0;
     }

    /****m lib/LnhLnhCfactory->CreateOrder
     *   NAME
     *      CreateOrder
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      新增訂單
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function CreateOrder($ManagerID=0,$OrderMan='',$PdsID=0,$PdsName='',$Price=0,$Count=0,$Note='',$CreateMan='') {
        if (!$ManagerID or !$OrderMan or !$PdsID or !$PdsName or !$Price or !$Count or !Note or !$CreateMan) return 0;
		$tt = time();
		$fileds = "ManagerID,OrderMan,PdsID,PdsName,Price,Count,Note,CreateMan,CreateDate,EditDate,EditMan,Status";
		$values = "$ManagerID,'$OrderMan ',$PdsID,'$PdsName ',$Price,$Count,'$Note ','$CreateMan ',$tt,$tt,'',1";
		if ($this->LnhDBH->SqlInsert($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER,$fileds,$values)) {
			return $this->getLastInsertID($this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER);	
		}
		//echo $this->LnhDBH->SqlStm;exit();
		return 0;                  
	 }
	 
    /****m lib/LnhLnhCfactory->UpdateOrder
     *   NAME
     *      UpdateOrder
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      更新訂單
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function UpdateOrder($RecordID=0,$OrderMan='',$PdsID=0,$PdsName='',$Price=0,$Count=0,$Note='',$EditMan='',$Status=0) {
         if(!$RecordID) return 0;
     	 $tt = time();
     	 $values  = "OrderMan='$OrderMan,PdsID=$PdsID,PdsName='$PdsName ',Price=$Price,Count=$Count,Note='$Note',EditMan='$EditMan ',Status=$Status,";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER, $values ,$condition);
     	 if($tmp) return 1;
		 //	echo $this->LnhDBH->SqlStm;
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetOrderDetailsByRecordID
     *   NAME
     *      GetOrderDetailsByRecordID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取一筆訂單明細資料
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetOrderDetailsByRecordID($RecordID=0) {
     	if(!$RecordID) return 0;
     	
     	$fileds = "*";
     	$condition = "RecordID=$RecordID";
     	if ($row = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER,$fileds,$condition))) {
			//echo $this->LnhDBH->SqlStm;
     	    return $row;
     	} 
     	return 0;
     }
	 
    /****m lib/LnhLnhCfactory->UpdateOrderStatusByRecordID
     *   NAME
     *      UpdateOrderStatusByRecordID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      更新使用者訂單狀態
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function UpdateOrderStatusByRecordID($RecordID=0,$Status=0,$EditMan='') {
         if(!$RecordID or !$Status or !$EditMan) return 0;
     	 $tt = time();
     	 $values  = "Status=$Status,EditDate=$tt,EditMan='$EditMan '";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER, $values ,$condition);
     	 //echo $this->LnhDBH->SqlStm;
		 if($tmp) return 1;
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetOrderDetailsPageByManagerID
     *   NAME
     *      GetOrderDetailsPageByManagerID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取指定商家明細分頁全部資料
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function GetOrderDetailsPageByManagerID($ManagerID=0,$Status=0,$PayType=0,$startRow=0,$maxRows=10) {
     	 if (!$ManagerID) return 0;
		 $values = "*";
         $condition = "1=1 and Status!=9 and ManagerID=$ManagerID";
         if($Status) $condition .= " and Status=$Status";
         if($PayType) $condition .= " and PayType=$PayType";
         $condition .= " order by Status,PdsID,CreateDate Desc ";
		 //$condition = "SupplyID=$SupplyID";
         if ($rows = $this->LnhDBH->SqlDataPageSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER,$values,$condition,$startRow,$maxRows)) {
			//echo $this->LnhDBH->SqlStm;exit();
       		return $rows;
         }
         return 0;
     }
	 
    /****m lib/LnhLnhCfactory->GetOrderDetailsPageCountByManagerID
     *   NAME
     *      GetOrderDetailsPageCountByManagerID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      擷取指定商家明細分頁全部資料
     *   INPUT
     *      
     *   OUTPUT
     *      
     ****
     */
     public function GetOrderDetailsPageCountByManagerID($ManagerID=0,$Status=0,$PayType=0) {
     	 if (!$ManagerID) return 0;
		 $values = "count(*)";
         $condition = "1=1 and Status!=9 and ManagerID=$ManagerID";
         if($Status) $condition .= " and Status=$Status";
         if($PayType) $condition .= " and PayType=$PayType";
         if ($row = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER,$values,$condition,$startRow,$maxRows))) {
			//echo $this->LnhDBH->SqlStm;exit();
       		return $row[0];
         }
         return 0;
     }
	 
    /****m lib/CmpCmpCfactory->LnhLogin
     *   NAME
     *      LnhLogin
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      訂便當程式登入確認
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function LnhLogin($AccountID='',$Password='') {
		if(!$AccountID or !$Password) return 0;
		// TODO: 設定使用者資料庫
     	//$Ums = new UmsUmsCfactory();
        //$AccountID = $Ums->UmsLogin($AccountID,$Password);
		//echo $AccountID;exit();
		$AccountID = 1;
		if ($AccountID) {
			return $this->SetOnline($AccountID);
		} 
		return 0;
     }
     
    /****m lib/LnhLnhCfactory->GetRemoteIP
     *   NAME
     *      GetRemoteIP
     *   AUTOOR
     *      Bill Yeh
     *   FUNCTION
     *      抓取遠端使用者的IP位置
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function GetRemoteIP() {
		$RemoteIP = $_SERVER["REMOTE_ADDR"];
		return $RemoteIP;
     }

    /****m lib/LnhLnhCfactory->AddOnline
     *   NAME
     *      AddOnine
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      新增Online資料
     *   INPUT
     *      
     *   OUTPUT
     *     
     ****
     */
     public function AddOnline($AccountID=''){
        if(!$AccountID) return 0;
      
        $tt = time();
        $SessionID = $this->setWhois();
		$RemoteIP = $this->GetRemoteIP();
        $fileds = "SessionID,Account,ActiveDate,CreateDate,RemoteIP";
        $values = "'$SessionID','$AccountID',$tt,$tt,'$RemoteIP'";
		if ($this->LnhDBH->SqlInsert($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ONLINE,$fileds,$values)) {
			return $this->getLastInsertID($this->LnhVariable->MY_SQL_TABLE_LUNCH_ONLINE);
        }
		return 0;
     }

    /****m lib/LnhLnhCfactory->SetOnline
     *   NAME
     *      SetOnline
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      新增Online資料
     *   INPUT
     *
     *   OUTPUT
     *     
     ****
     */
     public function SetOnline($AccountID=''){
        if(!$AccountID) return 0;
        $SessionID = $this->setWhois();
		//echo $SessionID;exit();
        if(!$SessionID) return 0;
        $tt = time();
        $RemoteIP = $this->GetRemoteIP();
   
        $fileds = "SessionID,Account,ActiveDate,CreateDate,RemoteIP";
        $values = "'$SessionID','$AccountID',$tt,$tt,'$RemoteIP'";
        if ($this->LnhDBH->SqlInsert($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ONLINE,$fileds,$values)) {
			//echo "OK";exit();
			return $SessionID;
        }
		//echo $this->LnhDBH->SqlStm."<br>";
		echo mysql_error();
        return 0;
     }
    
    /****m lib/LnhLnhCfactory->setWhois
     *   NAME
     *      setWhois
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      新增Whois資料
     *   INPUT
     *
     *   OUTPUT
     *      
     ****
     */
     public function setWhois() {
		list($usec, $sec) = explode(' ', microtime());
        $key = (float) $sec + ((float) $usec * 100000);
        srand($key);
        $randval = rand();
        $SessionID = md5($key.$this->SecretWord);
		$LiftTime = time();
		setcookie("LunchWhoIs",$SessionID,0,"/","",0);
        //setcookie("LunchWhoIs",$SessionID,0,"/",".plusgroup.com.tw",0); // 因應網址要有變化
		return $SessionID;
     }

    /****m lib/LnhLnhCfactory->GetOnline
     *   NAME
     *      GetOnline
     *   AUTHOR
     *   FUNCTION
     *      利用 Whois 取得 Online 資料
     *   INPUT
     *      
     *   OUTPUT
     *
     ****
     */
     public function GetOnline() {
        global $_COOKIE;
		
        $tt = time();
		$whois = isset($_COOKIE['LunchWhoIs'])?$_COOKIE['LunchWhoIs']:'';
		//echo $whois;exit();
        $fileds = "*";
        $condition = "(($tt-ActiveDate)<=7200) and SessionID='$whois'";
        $infos = $this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ONLINE,$fileds,$condition);
        //echo $this->LnhDBH->SqlStm;
		if(!$infos) return 0;
        $info = $this->LnhDBH->fetch_array($infos);
		//echo "<pre>";echo print_r($info);echo "</pre>";exit();
        $this->UpdateOnlineActiveByOnlineID($info[0]);
		return $info;
     }

    /****m lib/LnhLnhCfactory->UpdateOnlineActiveByOnlineID
     *   NAME
     *      UpdateOnlineActiveByOnlineID
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      利用 Whois取得Online資料
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     public function UpdateOnlineActiveByOnlineID($OnlineID=0) {
		if(!$OnlineID) return 0;
        $values= "ActiveDate=".time();
        $condition = "OnlineID=$OnlineID order by CreateDate desc";
        $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ONLINE, $values ,$condition);
        if ($tmp) return 1;
        return 0;
     }
     
    /****m lib/LnhLnhCfactory->PopMsg
     *   NAME
     *      PopMsg
     *   AUTHOR
     *      Bill Yeh
     *   FUNCTION
     *      顯示視窗訊息,並導引至下個網頁
     *   INPUT
     *
     *   OUTPUT
     *
     ****
     */
     Public Function PopMsg($str='',$url='') {
		echo "<script language='JavaScript'>\n\r";
		echo "<!--\n\r";
		echo " alert(\"".$str."\");\n\r";
		if ($url<>"") {
			echo " location='".$url."';\n\r";
		}
		echo " //-->\n\r";
		echo "</script>\n\r";
     }     

 } // end class
?>
