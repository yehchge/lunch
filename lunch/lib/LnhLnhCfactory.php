<?php

// declare(strict_types=1); // 嚴格類型

include_once PATH_ROOT."/lunch/gphplib/SysRdbCconnection.php";
include_once PATH_ROOT."/lunch/lib/LnhRdbCglobal.php";

class LnhLnhCfactory extends SysRdbCconnection {

    public $LnhDBH;
    public $LnhValriables;
    public $LnhVariable;

    var $file = "/usr/local/apache2/htdocs/adm/lib/system.ini.php";
    var $SecretWord="ieatlunch";
    

     public function __construct() {
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
    
    public function UpdateStore($RecordID=0,$UserName='',$Password='',$StoreName='',$StoreIntro='',$StoreClass='',$MainMan='',$Tel='',$Address='',$EditMan='',$Note='',$Status=0) {
        if(!$RecordID) return 0;

        $data = [
            'UserName'   => $UserName,
            'Password'   => $Password,
            'StoreName'  => $StoreName,
            'StoreIntro' => $StoreIntro,
            'StoreClass' => $StoreClass,
            'MainMan'    => $MainMan,
            'Tel'        => $Tel,
            'Address'    => $Address,
            'EditMan'    => $EditMan,
            'EditDate'   => time(),
            'Note'       => $Note,
            'Status'     => $Status,
        ];

        $tmp = $this->LnhDBH->update($this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE, $data, 'RecordID = ?', [$RecordID]);

         // $values  = "UserName='$UserName ',";
         // $values .= "Password='$Password ',";
         // $values .= "StoreName='$StoreName ',";
         // $values .= "StoreIntro='$StoreIntro ',";
         // $values .= "StoreClass='$StoreClass ',";
         // $values .= "MainMan='$MainMan ',";
         // $values .= "Tel='$Tel ',";
         // $values .= "Address='$Address ',";
         // $values .= "EditMan='$EditMan ',";
         // $values .= "EditDate=$tt,";
         // $values .= "Note='$Note ',";
         // $values .= "Status=$Status";
         // $condition = "RecordID=$RecordID";
         // $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE, $values ,$condition);

         

         if($tmp) return 1;
         
         return 0;
    }
     
     public function GetAllStore() {
         $fileds = "*";
         if ($rows = $this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE,$fileds,"1=1"))
              {
                 return $rows;
              }
          return 0;
     }
     
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
    

     public function GetAllStorePage($Status=0,$Name='',$PayType=0,$startRow=0,$maxRows=10) {
         $values = "*";
         $condition = "1=1";
         if($Status) $condition.= " and Status=$Status";
         if($Name) $condition .= " and Name like '%$Name''";
         if($PayType) $condition .= " and PayType=$PayType";
         $condition .= " order by CreateDate Desc ";
         //$condition = "SupplyID=$SupplyID";
         if ($rows = $this->LnhDBH->SqlDataPageSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE,$values,$condition,$startRow,$maxRows)) {
            // echo $this->LnhDBH->SqlStm;exit();
            return $rows;
         }
         return 0;
     }
     
     public function GetAllStoreCount($Status=0) {
        $fileds = "count(*)";
        $condition = "1=1";
        if($Status) $condition.= " and Status=$Status";
        if ($rows = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_STORE,$fileds,$condition))) {
            return $rows[0];
        }
        return 0;
     }

     public function CreateProduct($StoreID=0,$PdsName='',$PdsType='',$Price=0,$CreateMan='',$Note='') {
        if (!$StoreID or !$PdsName or !$Price or !$CreateMan) return 0;
        
        $tt = time();

        $data = [
            'StoreID' => $StoreID,
            'PdsName' => $PdsName,
            'PdsType' => $PdsType,
            'Price' => $Price,
            'CreateMan' => $CreateMan,
            'Note' => $Note,
            'Status' => 1,
            'CreateDate' => $tt,
            'EditDate' => $tt,
            'EditMan' => ''
        ];

        if ($this->LnhDBH->insert($this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT, $data)){
            return $this->LnhDBH->lastInsertId();
        }

        // $fileds = "StoreID,PdsName,PdsType,Price,CreateMan,Note,Status,CreateDate,EditDate,EditMan";
        // $values = "$StoreID,'$PdsName ','$PdsType ',$Price,'$CreateMan ','$Note ',1,$tt,$tt,''";
        // if ($this->LnhDBH->SqlInsert($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT,$fileds,$values)) {
        //     return $this->getLastInsertID($this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT);  
        // }
        return 0;                  
     }


    public function UpdateProduct($RecordID=0,$StoreID=0,$PdsName='',$PdsType='',$Price=0,$EditMan='',$Note='',$Status=0) {
        if(!$RecordID) return 0;
        $tt = time();

        $data = [
            'StoreID' => $StoreID,
            'PdsName' => $PdsName,
            'PdsType' => $PdsType,
            'Price' => $Price,
            'EditMan' => $EditMan,
            'EditDate' => $tt,
            'Note' => $Note,
            'Status' => $Status
        ];

        $tmp = $this->LnhDBH->update($this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT, $data, 'RecordID = ?', [$RecordID]);

        // $values  = "StoreID=$StoreID,PdsName='$PdsName ',PdsType='$PdsType ',Price=$Price,";
        // $values .= "EditMan='$EditMan ',EditDate=$tt,Note='$Note ',Status=$Status";
        // $condition = "RecordID=$RecordID";
        // $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT, $values ,$condition);
         
        if($tmp) return 1;
        // echo $this->LnhDBH->SqlStm;
        return 0;
    }


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
     

     public function GetAllProductByStore($StoreID=0) {
         if (!$StoreID) return 0;
         $fileds = "*";
         $condition = "StoreID=$StoreID";
         if ($rows = $this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_PRODUCT,$fileds,$condition)) {
            return $rows;
         }
         return 0;
     }

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

     public function UpdateManager($RecordID=0,$StoreID=0,$Manager='',$Note='',$Status=0,$EndDate='') {
         if(!$RecordID) return 0;
         $tt = time();
         $values  = "StoreID=$StoreID,Manager='$Manager',Note='$Note',Status=$Status,";
         $values .= "EditDate=$tt,EndDate='$EndDate'";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER, $values ,$condition);
         if($tmp) return 1;
         // echo $this->LnhDBH->SqlStm;
         return 0;
     }

     public function UpdateManagerStatusByRecordID($RecordID=0,$Status=0) {
         if(!$RecordID or !$Status) return 0;
         $tt = time();
         $values  = "Status=$Status,EditDate=$tt";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER, $values ,$condition);
         if($tmp) return 1;
         // echo $this->LnhDBH->SqlStm;
         return 0;
     }
     

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
     
     public function GetActiveManagerPageCount() {
        $fileds = "count(*)";
        $condition = "Status in (1,2)";
        if ($rows = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER,$fileds,$condition))) {
            return $rows[0];
        }
        return 0;
     }
     

     public function GetAllManagerCount($Status=0) {
        $fileds = "count(*)";
        $condition = "1=1 and Status!=9";
        if ($Status) $condition .= " and Status=$Status";
        if ($rows = $this->LnhDBH->fetch_array($this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_MANAGER,$fileds,$condition))) {
            return $rows[0];
        }
        return 0;
     }


     public function CreateOrder($ManagerID=0,$OrderMan='',$PdsID=0,$PdsName='',$Price=0,$Count=0,$Note='',$CreateMan='') {
        if (!$ManagerID or !$OrderMan or !$PdsID or !$PdsName or !$Price or !$Count  or !$CreateMan) return 0;
        $tt = time();
        $fileds = "ManagerID,OrderMan,PdsID,PdsName,Price,Count,Note,CreateMan,CreateDate,EditDate,EditMan,Status";
        $values = "$ManagerID,'$OrderMan ',$PdsID,'$PdsName ',$Price,$Count,'$Note ','$CreateMan ',$tt,$tt,'',1";
        if ($this->LnhDBH->SqlInsert($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER,$fileds,$values)) {
            return $this->getLastInsertID($this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER);    
        }
        //echo $this->LnhDBH->SqlStm;exit();
        return 0;                  
     }
     

     public function UpdateOrder($RecordID=0,$OrderMan='',$PdsID=0,$PdsName='',$Price=0,$Count=0,$Note='',$EditMan='',$Status=0) {
         if(!$RecordID) return 0;
         $tt = time();
         $values  = "OrderMan='$OrderMan,PdsID=$PdsID,PdsName='$PdsName ',Price=$Price,Count=$Count,Note='$Note',EditMan='$EditMan ',Status=$Status,";
         $condition = "RecordID=$RecordID";
         $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ORDER, $values ,$condition);
         if($tmp) return 1;
         // echo $this->LnhDBH->SqlStm;
         return 0;
     }

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
     

     public function GetOrderDetailsPageCountByManagerID($ManagerID=0,$Status=0,$PayType=0,$startRow=0,$maxRows=10) {
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

     public function LnhLogin($AccountID='', $Password='') {
        if(!$AccountID or !$Password) return 0;

        if($AccountID=='admin' && $Password=='admin'){
            // TODO: 設定使用者資料庫
            //$Ums = new UmsUmsCfactory();
            //$AccountID = $Ums->UmsLogin($AccountID,$Password);
            //echo $AccountID;exit();
            $AccountID = 1;
            if ($AccountID) {
                return $this->SetOnline($AccountID);
            }            
        }

        return 0;
     }
     

     public function GetRemoteIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim(end($ips));
        }
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
     }


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
            return $SessionID;
        }
        //echo $this->LnhDBH->SqlStm."<br>";
        echo $this->LnhDBH->ConnID->errorInfo();
        return 0;
     }
    
     public function setWhois() {
        list($usec, $sec) = explode(' ', microtime());
        $key = (float) $sec + ((float) $usec * 100000);
        srand((int)$key);
        $randval = rand();
        $SessionID = md5($key.$this->SecretWord);
        $LiftTime = time();
        setcookie("LunchWhoIs",$SessionID,0,"/","",0);
        //setcookie("LunchWhoIs",$SessionID,0,"/",".plusgroup.com.tw",0); // 因應網址要有變化
        return $SessionID;
     }

     public function GetOnline() {
        global $_COOKIE;

        $tt = time();
        $whois = isset($_COOKIE['LunchWhoIs'])?$_COOKIE['LunchWhoIs']:'';

        $fileds = "*";
        $condition = "(($tt-ActiveDate)<=7200) and SessionID='$whois'";
        $infos = $this->LnhDBH->SqlSelect($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ONLINE,$fileds,$condition);


        //echo $this->LnhDBH->SqlStm;
        if(!$infos) return 0;
        $info = $this->LnhDBH->fetch_array($infos);
        // echo "<pre>";echo print_r($info);echo "</pre>";exit();
        $this->UpdateOnlineActiveByOnlineID($info[0]);
        return $info;
     }


     public function UpdateOnlineActiveByOnlineID($OnlineID=0) {
        if(!$OnlineID) return 0;
        $values= "ActiveDate=".time();
        $condition = "OnlineID=$OnlineID order by CreateDate desc";
        $tmp = $this->LnhDBH->SqlUpdate($this->LnhVariable->MY_SQL_DB_LUNCH,$this->LnhVariable->MY_SQL_TABLE_LUNCH_ONLINE, $values ,$condition);
        if ($tmp) return 1;
        return 0;
     }

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

}