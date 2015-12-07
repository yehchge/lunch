<?php

//echo "系統更新維護,請稍後!!";
//exit();
/****c gphplib/SysRdbCconnection 
*   NAME
*      SysRdbCconnection
*   COPYRIGHT
*      @Com. Internet Marketing Co., Ltd.
*   FUNCTION
*      連接資料庫之父類別
*   AUTHOR
*   HISTORY
*      12/23/2003		1.0	creater
****
*/
class SysRdbCconnection {

	var $ConnStr;
	var $ConnDb;
	var $ConnUid;
	var $ConnPwd;
	var $ConnPort;
	var $ConnHost;
	var $ConnID;
	var $DbType;
	var $Status;
	var $conn;
	var $ErrorCode;
	var $MY_SQL_SERVER=1;
	var $OR_SQL_SERVER=2;
	var $ORA_SQL_SERVER=3;
	var $MS_SQL_SERVER=4;
	var $ErrorString;      
	var $Rows;

	/****m gphplib/SysRdbCconnection->SysRdbCconnection
	*   NAME
	*      SysRdbCconnection
	*   SYNOPSIS
	*      null SysRdbCconnection ($arg1,$arg2,$arg3,$arg4,$arg5,$arg6,$arg7)
	*   FUNCTION
	*      建構子
	*   INPUTS
	*      $arg1: Connect String(for xDBC)
	*      $arg2: Database(使用哪個資料庫)
	*      $arg3: Uid(使用者)
	*      $arg4: Pwd(密碼)
	*      $arg5: Port(tcp/ip port)
	*      $arg6: Host(主機名稱,database server)
	*      $arg7: Db Type(使用哪種database server)
	*   AUTHOR
	****
	*/
	function SysRdbCconnection($arg1=NULL,$arg2=NULL,$arg3=NULL,$arg4=NULL,$arg5=NULL,$arg6=NULL,$arg7=NULL){
		$this->ConnStr=$arg1;
		$this->ConnDb=$arg2;
		$this->ConnUid=$arg3;
		$this->ConnPwd=$arg4;
		$this->ConnPort=$arg5;
		$this->ConnHost=$arg6;
		if($arg7==NULL)
			$this->DbType=$this->MY_SQL_SERVER;
		else
			$this->DbType=$arg7;
		$this->Status=0;
		$this->ErrorCode=1;
		$this->ErrorString="我的天啊!!";
		$this->Rows=20;
	}

	/****m gphplib/SysRdbCconnection->isConnected
	*   NAME
	*      isConnected
	*   SYNOPSIS
	*      int isConnected ()
	*   FUNCTION
	*	是否已連結資料庫
	*   OUTPUT
	*      int	0: not connect   1: connected
	*   AUTHOR
	****
	*/
	function isConnected(){
		return $this->Status;
	}

	/****m gphplib/SysRdbCconnection->setConnStr
	*   NAME
	*      setConnStr
	*   SYNOPSIS
	*      int setConnStr ($argConnStr)
	*   FUNCTION
	*      設定連結字串(xDBC)
	*   INPUTS
	*      $argConnStr: 連結字串
	*   OUTPUT
	*      int	0: Fail	1: Success
	*   AUTHOR
	****
	*/
	function setConnStr($argConnStr){
		if($this->Status==0){
			$this->ConnStr=$argConnStr;
			return 1;
		} else return 0;             
	}

	/****m gphplib/SysRdbCconnection->getConnStr
	*   NAME
	*      getConnStr
	*   SYNOPSIS
	*      String getConnStr()
	*   FUNCTION
	*      得到連結字串(xDBC)
	*   OUTPUT
	*      連結字串
	*   AUTHOR
	****
	*/
	function getConnStr(){
		return $this->ConnStr;
	}

	/****m gphplib/SysRdbCconnection->setConnDb
	*   NAME
	*      setConnDb
	*   SYNOPSIS
	*      int setConnDb($argConnDb)
	*   FUNCTION
	*      設定連結之資料庫名稱
	*   INPUTS
	*      $argConnDb: 連結之資料庫名稱
	*   OUTPUT
	*      0: Fail        
	*       1: Success
	*   AUTHOR
	****
	*/
	function setConnDb($argConnDb){
		if($this->Status==0){
			$this->ConnDb=$argConnDb;
			return 1;
		} else return 0;
	}

	/****m gphplib/SysRdbCconnection->getConnDb
	*   NAME
	*      getConnDb
	*   SYNOPSIS
	*      String getConnDb()
	*   FUNCTION
	*      得到連結之資料庫名稱
	*   OUTPUT
	*      連結之資料庫名稱 
	*   AUTHOR
	****
	*/
	function getConnDb(){
		return $this->ConnDb;
	}

	/****m gphplib/SysRdbCconnection->setConnUid
	*   NAME
	*      setConnUid
	*   SYNOPSIS
	*      int setConnUid($argConnUid)
	*   FUNCTION
	*      設定登入資料庫之使用者
	*   INPUTS
	*      $argConnUid: 連結使用者
	*   OUTPUT
	*      0: Fail        
	*      1: Success
	*   AUTHOR
	****
	*/
	function setConnUid($argConnUid){
		if($this->Status==0){
			$this->ConnUid=$argConnUid;
			return 1;
		} else return 0;
	}

	/****m gphplib/SysRdbCconnection->getConnUid
	*   NAME
	*      getConnUid
	*   SYNOPSIS
	*      String getConnUid()
	*   FUNCTION
	*      得到使用者名稱
	*   OUTPUT
	*      使用者代號
	*   AUTHOR
	****
	*/
	function getConnUid(){
		return $this->ConnUid;
	}

	/****m gphplib/SysRdbCconnection->setConnPwd
	*   NAME
	*      setConnPwd
	*   SYNOPSIS
	*      int setConnPwd($argConnPwd)
	*   FUNCTION
	*      設定登入資料庫(連結)之密碼 
	*   INPUTS
	*      $argConnPwd: 連結之密碼
	*   OUTPUT
	*      0: Fail        
	*      1: Success
	*   AUTHOR
	****
	*/
	function setConnPwd($argConnPwd){
		if($this->Status==0){
			$this->ConnPwd=$argConnPwd;
			return 1;
		} else return 0;
	}

	/****m gphplib/SysRdbCconnection->getConnPwd
	*   NAME
	*      getConnPwd
	*   SYNOPSIS
	*      String getConnPwd
	*   FUNCTION
	*      得到設定連結之密碼
	*   OUTPUT
	*      設定連結之密碼
	*   AUTHOR
	****
	*/
	function getConnPwd(){
		return $this->ConnPwd;
	}

	/****m gphplib/SysRdbCconnection->setConnPort
	*   SYNOPSIS
	*      int setConnPort($argConnPort)
	*   NAME
	*      setConnPort
	*   FUNCTION
	*      設定連結Port #
	*   INPUTS
	*      $argConnPort: 連結之Port Num
	*   OUTPUT
	*      0: Fail       
	*      1: Success
	*   AUTHOR
	**** 
	*/
	function setConnPort($argConnPort){
		if($this->Status==0){
			$this->ConnPort=$argConnPort;
			return 1;
		} else return 0;
	}


	/****m gphplib/SysRdbCconnection->getConnPort
	*   SYNOPSIS
	*      String getConnPort()
	*   NAME
	*      getConnPort
	*   FUNCTION
	*      得到設定連結Port Num
	*   OUTPUT
	*      設定連結Port Num
	*   AUTHOR
	****
	*/
	function getConnPort(){
		return $this->ConnPort;
	}

	/****m gphplib/SysRdbCconnection->setConnHost
	*   SYNOPSIS
	*      int setConnHost($argConnHost)
	*   NAME
	*      setConnHost
	*   FUNCTION
	*      設定連結之主機/資料庫名稱
	*   INPUTS
	*      $argConnHost：主機/資料庫名稱 ? *   OUTPUT
	*      0: Fail       
	*      1: Success
	*   AUTHOR
	****
	*/
	function setConnHost($argConnHost){
		if($this->Status==0){
			$this->ConnHost=$argConnHost;
			return 1;
		} else return 0;
	}

	/****m gphplib/SysRdbCconnection->getConnDb
	*   NAME
	*      getConnDb
	*   SYNOPSIS
	*      String getConnHost()
	*   FUNCTION
	*      得到連結之主機/資料庫名稱
	*   OUTPUT
	*      連結之主機/資料庫名稱
	*   AUTHOR
	****
	*/
	function getConnHost(){
		return $this->ConnHost;
	}

	/****m gphplib/SysRdbCconnection->setDbType
	*   NAME
	*      setDbType
	*   SYNOPSIS
	*      int setDbType($argDbType)
	*   FUNCTION
	*      設定資料庫種類(mysql , oracle ...)
	*   INPUTS
	*      $argDbType: 設定資料庫種類
	*   OUTPUT
	*      0: Fail        
	*      1: Success
	*   AUTHOR
	****
	*/
	function setDbType($argDbType){
		if($this->Status==0){
			$this->DbType=$argDbType;
            return 1;
		} else return 0;
	}

	/****m gphplib/SysRdbCconnection->getDbType
	*   NAME
	*      getDbType
	*   SYNOPSIS
	*      String getDbType()
	*   FUNCTION
	*      得到設定資料庫種類
	*   OUTPUT
	*      設定資料庫種類
	*   AUTHOR
	****
	*/
	function getDbType(){
		return $this->DbType;
	}

	/****m gphplib/SysRdbCconnection->activate
	*   NAME
	*      activate(virtual function)
	*   SYNPOSIS
	*      int activate()
	*   FUNCTION
	*      連結資料庫
	*   OUTPUT
	*      0:fail 
	*      1:success
	*   AUTHOR
	****
	*/
	function activate(){
		if($this->DbType==$this->MY_SQL_SERVER){
			$temp=mysql_pconnect($this->ConnHost,$this->ConnUid,$this->ConnPwd);
			if($temp>0){
				$this->Status=1;
				$this->ConnID=$temp;
			} else {
				$this->Status=0;
				header("http/1.0 404 Not Found"); 
			}
		}
		if($this->DbType==$this->OR_SQL_SERVER){
			$this->conn = OCILogon($this->ConnUid,$this->ConnPwd,$this->ConnDb);
			$this->Status=1;
		}
		if($this->DbType==$this->MS_SQL_SERVER){
			$temp=mssql_connect($this->ConnHost,$this->ConnUid,$this->ConnPwd);
			if($temp>0){
				$this->Status=1;
				$this->ConnID=$temp;
			} else {
				$this->Status=0;
				header("http/1.0 404 Not Found"); 
			}
		}
		return $this->Status;
	}

	/****m gphplib/SysRdbCconnection->SqlPageSelect
	*   NAME
	*      SqlPageSelect
	*   SYNOPSIS
	*      ResultSet SqlPageSelect($argDb,$argTable,$argField,$argCondition,$argRowsBegin,$argRows)
	*   FUNCTION
	*     查詢
	*   INPUTS
	*     $argDb:資料庫
	*     $argTable: Table
	*     $argField: 欄位
	*     $argCondition: Where 子句
	*     $argRowsBegin: 第幾筆開始
	*     $argRows: 共抓幾筆出來
	*   OUTPUT
	*      Ret['TOTAL_ROWS']: 共有多少筆 (只有$argRowsBegin==NULL才有此值)
	*      Ret[$i]['DATA']: Result set,$i=total data fetched
	*      Ret['ROWS']: 共抓了多少筆
	*   AUTHOR
	****
	*/
	function SqlPageSelect($argDb,$argTable,$argField,$argCondition,$argRowsBegin=NULL,$argRows=NULL) {
		if ($argRows) $this->Rows=$argRows;
		if (!$argRowsBegin) $argRowsBegin=0;          
		if ($argCondition!=NULL) {
			//if(!$argRowsBegin)
			$this->SqlStm="select count(*) from $argTable where $argCondition";            
			//$this->SqlStm="select $argField from $argTable where $argCondition";
		} else {
			//  if(!$argRowsBegin)
			$this->SqlStm="select count(*) from $argTable";
			//$this->SqlStm="select $argField from $argTable";
		}

		// 使用mysql
		if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1) {
			if (!mysql_select_db($argDb, $this->ConnID)) {
				echo '1:Could not use '.$argDb.' : '.mysql_error();
				exit;
			}
			$Result = mysql_query($this->SqlStm, $this->ConnID);
			//$Result=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
			$ResultTotal=0;
			while ($temp[$ResultTotal]=$this->fetch_array($Result)) $ResultTotal++;
			if($ResultTotal!=1){
				$Ret['TOTAL_ROWS']=$ResultTotal;
			} else {
				$Ret['TOTAL_ROWS']=$temp[0][0];
			}

			if($argCondition)
				$this->SqlStm="select $argField from $argTable where $argCondition limit $argRowsBegin,".$this->Rows;
			else
				$this->SqlStm="select $argField from $argTable limit 0,".$this->Rows;

			// $Ret['DATA']=mysql_db_query($argDb,$this->SqlStm);
			if (!mysql_select_db($argDb, $this->ConnID)) {
				echo '1:Could not use '.$argDb.' : '.mysql_error();
				exit;
			}
			$temp = mysql_query($this->SqlStm, $this->ConnID);
			//$temp=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
			if(!$temp){
				$this->ErrorCode=0;
				$this->ErrorString=mysql_error();
				return 0;
			} else {
				$i=0;
				while($Row=$this->fetch_array($temp)){
					$Ret[$i]['DATA']=$Row;
					$i++;
				}
				$Ret['ROWS']=$i;
				return $Ret;
			}
		}
		
		if($this->DbType==$this->OR_SQL_SERVER and $this->Status==1){
            $stmt = OCIParse($this->conn,$this->SqlStm);
            OCIExecute($stmt);
            $Ret['TOTAL_ROWS']=$stmt[0];

            if($argCondition)
				$this->SqlStm="select $argField from $argTable where $argCondition";
            else
               $this->SqlStm="select $argField from $argTable";
            $stmt2 = OCIParse($this->conn,$this->SqlStm);
            OCIExecute($stmt2);
			//$Ret['DATA']=$stmt2;
            $i=0;
            $j=0;
            while($Row=$this->fetch_array($stmt2)){
				if($i>$argRowsBegin && $j<$this->Rows){
					$Ret[$j]['DATA']=$Row;
					$j++;
				};
				$i++;
			}
            $Ret['ROWS']=$j;
            return $Ret;
		} 

		// 使用msqsl
		if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1){
			$Result=mssql_db_query($argDb,$this->SqlStm,$this->ConnID);
			//$Result=mysql_db_query($argDb,$this->SqlStm);
			$ResultTotal=0;
			while($temp[$ResultTotal]=$this->fetch_array($Result)) $ResultTotal++;
			if($ResultTotal!=1){
				$Ret['TOTAL_ROWS']=$ResultTotal;
            } else {
				$Ret['TOTAL_ROWS']=$temp[0][0];
            }

			if($argCondition)
				$this->SqlStm="select $argField from $argTable where $argCondition limit $argRowsBegin,".$this->Rows;
            else
				$this->SqlStm="select $argField from $argTable limit 0,".$this->Rows;

			// $Ret['DATA']=mysql_db_query($argDb,$this->SqlStm);
			$temp=mssql_db_query($argDb,$this->SqlStm,$this->ConnID);
			//$temp=mysql_db_query($argDb,$this->SqlStm);
			if(!$temp){
				$this->ErrorCode=0;
				$this->ErrorString=mysql_error();
				return 0;
			} else {
				$i=0;
				while($Row=$this->fetch_array($temp)){
					$Ret[$i]['DATA']=$Row;
					$i++;
				}
				$Ret['ROWS']=$i;
				return $Ret;
			}
		}
		 
		$this->ErrorCode=0;
		return 0;
	}

	/****m gphplib/SysRdbCconnection->SqlSelect
	*   NAME
	*      SqlSelect
	*   SYNOPSIS
	*      ResultSet SqlSelect($argDb,$argTable,$argField,$argCondition)
	*   FUNCTION
	*     查詢
	*   INPUTS
	*     $argDb:資料庫
	*     $argTable: Table
	*     $argField: 欄位
	*     $argCondition: Where 子句
	*   OUTPUT
	*      ResultSet
	*   AUTHOR
	****
	*/
	function SqlSelect($argDb,$argTable,$argField,$argCondition){
		mysql_query('SET NAMES big5');
		if($argCondition!=NULL)
			$this->SqlStm="select $argField from $argTable where $argCondition";
		else
			$this->SqlStm="select $argField from $argTable";
		// 使用mysql
		if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1) {
			if (!mysql_select_db($argDb, $this->ConnID)) {
				echo '1:Could not use '.$argDb.' : '.mysql_error();
				exit;
			}
			
			$Ret = mysql_query($this->SqlStm, $this->ConnID);
		
			//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);  
			return $Ret;
	  
			if($Ret<=0) {
				$this->ErrorCode=0;
				$this->ErrorString=mysql_error();
				return 0;
			} else {
				return $Ret;
			}
		}
			
		// 使用mssql
		if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1) {
			mssql_select_db($argDb,$this->ConnID);
			$Ret=mssql_query($this->SqlStm,$this->ConnID);  
			return $Ret;
	  
			if($Ret<=0) {
				$this->ErrorCode=0;
				$this->ErrorString=mssql_error();
				return 0;
			} else {
				return $Ret;
			}
		}
	 
		if($this->DbType==$this->OR_SQL_SERVER and $this->Status==1) {
			$stmt = OCIParse($this->conn,$this->SqlStm);
			OCIExecute($stmt);
			return $stmt;
		}           
		$this->ErrorCode=0;
		return 0;
	}
     
	/****m gphplib/SysRdbCconnection->SqlDataPageSelect
	*   NAME
	*      SqlDataPageSelect
	*   SYNOPSIS
	*      ResultSet SqlDataPageSelect($argDb,$argTable,$argField,$argCondition,$argRowsBegin,$argRows)
	*   FUNCTION
	*     查詢
	*   INPUTS
	*     $argDb:資料庫
	*     $argTable: Table
	*     $argField: 欄位
	*     $argCondition: Where 子句
	*     $argRowsBegin: 第幾筆開始
	*     $argRows: 共抓幾筆出來
	*   OUTPUT
	*     ResultSet
	*   AUTHOR
	****
	*/
	function SqlDataPageSelect($argDb,$argTable,$argField,$argCondition,$argRowsBegin=NULL,$argRows=NULL){
		//echo $argDb."<br>".$argTable."<br>".$argField."<br>".$argCondition."<br>".$argRowsBegin."<br>".$argRows;exit();
		if($argRows)
			//$Rows=$argRows;
			$this->Rows=$argRows;
		if(!$argRowsBegin)
			$argRowsBegin=0;          
		if($argCondition)
			$this->SqlStm="select $argField from $argTable where $argCondition limit $argRowsBegin,".$this->Rows;
		else
            $this->SqlStm="select $argField from $argTable limit 0,".$this->Rows;
		// 使用mysql
		// echo $this->SqlStm;exit();
		if (!mysql_select_db($argDb, $this->ConnID)) {
			echo '1:Could not use '.$argDb.' : '.mysql_error();
			exit;
		}
		$Ret = mysql_query($this->SqlStm, $this->ConnID);
		//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID); 
		if(!$Ret){
			$this->ErrorCode=0;
			$this->ErrorString=mysql_error();
			return 0;
		} else {
			return $Ret;
		}
		if($Ret<=0){
			$this->ErrorCode=0;
			$this->ErrorString=mysql_error();
			return 0;
		} else {
			return $Ret;
		}
	}        

	/****m  gphplib/SysRdbCconnection->SqlInsert
	*   NAME
	*      SqlInsert
	*   SYNOPSIS
	*      int SqlInsert($argDb,$argTable,$argField,$argValues)
	*   FUNCTION
	*      新增
	*   INPUTS
	*      $argDb:資料庫
	*      $argTable: Table
	*      $argField: 欄位
	*      $argValues: 值(Values)
	*   OUTPUT
	*       0:fail 
	*       1:success
	*   AUTHOR
	****
	*/
	function SqlInsert($argDb,$argTable,$argField,$argValues){
		if($argValues!=NULL){
			//$argValues=htmlspecialchars($argValues);
			$this->SqlStm="insert into $argTable ($argField) values ($argValues)"; 
            //echo $this->SqlStm;exit();        
            // 使用 mysql 
            if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
				if (!mysql_select_db($argDb, $this->ConnID)) {
					echo '1:Could not use '.$argDb.' : '.mysql_error();
					exit;
				}
				$Ret = mysql_query($this->SqlStm, $this->ConnID);
				//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					$this->ErrorString=mysql_error();
					return 0;
				} else return $Ret;
			}
			
			// 使用 mssql 
            if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1){
				mssql_select_db($argDb,$this->ConnID);
				$Ret=mssql_query($this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					//$this->ErrorString=mssql_error();
					$this->ErrorString=mssql_get_last_message();
					return 0;
				} else return $Ret;
			}
			
			if($this->DbType==$this->OR_SQL_SERVER and $this->Status==1){
				$stmt = OCIParse($this->conn,$this->SqlStm);
				OCIExecute($stmt);
				return $stmt;
			}           
		} else return 0;
	}

	/****m gphplib/SysRdbCconnection->SqlUpdate 
	*   NAME
	*      SqlUpdate
	*   SYNOPSIS
	*      int SqlUpdate($argDb,$argTable,$argSetValue,$argCondition)
	*   FUNCTION
	*      更新
	*   INPUTS
	*      $argDb:資料庫
	*      $argTable: Table
	*	$argSetValue: 設定值
	*      $argCondition: Where 子句
	*   OUTPUT
	*      0:fail 
	*      1:success
	*   AUTHOR
	****
	*/
	function SqlUpdate($argDb,$argTable,$argSetValue,$argCondition){
		if($argCondition!=NULL){
			$this->SqlStm="update $argTable set $argSetValue where $argCondition";
			// 使用 mysql
			if($this->DbType==$this->MY_SQL_SERVER and $this->Status=1){ 
				if (!mysql_select_db($argDb, $this->ConnID)) {
					echo '1:Could not use '.$argDb.' : '.mysql_error();
					exit;
				}
				$Ret = mysql_query($this->SqlStm, $this->ConnID);
				//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					$this->ErrorString=mysql_error();
					return 0;
				} else return $Ret;
			}
		   
			// 使用 mssql
			if($this->DbType==$this->MS_SQL_SERVER and $this->Status=1){ 
				mssql_select_db($argDb,$this->ConnID);
				$Ret=mssql_query($this->SqlStm,$this->ConnID);
				if($Ret<=0) {
					$this->ErrorCode=0;
					//$this->ErrorString=mssql_error();
					$this->ErrorString=mssql_get_last_message();
					return 0;
				} else return $Ret;
			}
		   
			// 使用 oracle sql
			if($this->DbType==$this->OR_SQL_SERVER and $this->Status==1){
				$stmt = OCIParse($this->conn,$this->SqlStm);
				OCIExecute($stmt);
				return $stmt;
			}           
		} else return 0;
	}

	/****m gphplib/SysRdbCconnection->SqlDelete
	*   NAME
	*      SqlDelete
	*   SYNOPSIS
	*      int SqlDelete($argDb,$argTable,$argCondition)
	*   FUNCTION
	*      刪除
	*   INPUTS
	* 	$argDb:資料庫
	*	$argTable: Table
	*	$argCondition: Where 子句
	*   OUTPUT
	*      0:fail 
	*      1:success
	*   AUTHOR
	****
	*/
	function SqlDelete($argDb,$argTable,$argCondition){
		if($argCondition!=NULL){     
			$this->SqlStm="delete from $argTable where $argCondition";
			// 使用mysql
			if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
				if (!mysql_select_db($argDb, $this->ConnID)) {
					echo '1:Could not use '.$argDb.' : '.mysql_error();
					exit;
				}
				$Ret = mysql_query($this->SqlStm, $this->ConnID);
				//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					$this->ErrorString=mysql_error();
					return 0;
				} else return $Ret;
			}
		   
			// 使用mssql
			if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1){
				$Ret=mssql_db_query($argDb,$this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					$this->ErrorString=mssql_error();
					return 0;
				} else return $Ret;
			}

			if($this->DbType==$this->OR_SQL_SERVER and $this->Status==1){
				$stmt = OCIParse($this->conn,$this->SqlStm);
				OCIExecute($stmt);
				return $stmt;
			}           
		} else return 0;
	}

	/****m gphplib/SysRdbCconnection->fetch_array
	*   NAME
	*      fetch_array
	*   SYNOPSIS
	*      char[] fetch_array($argResult)
	*   FUNCTION
	*      將ResultSet一筆一筆抓出來
	*   INPUTS
	*      $argResult: ResultSet
	*   OUTPUT
	*      Row Array
	*   AUTHOR
	****
	*/
	function fetch_array($argResult){
		if($argResult!=NULL) {
			// 使用 mysql
			if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
				$rows = mysql_fetch_array($argResult,MYSQL_BOTH);
				// mysql_free_result($argResult);
				return $rows;
			}
			
			// 使用 mssql
			if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1){
				$rows = mssql_fetch_array($argResult,MSSQL_BOTH);
				// mssql_free_result($argResult);
				return $rows;
            }
			
            if($this->DbType==$this->OR_SQL_SERVER and $this->Status==1){
				// OCIFetchInto($argResult, &$res); 
				return $res;
			}
            return 0;
		} else return 0;
	}
	
	function lockTable($argDb,$TableCondition){
		if($TableCondition!=NULL){
			$this->SqlStm="LOCK TABLES $TableCondition";
			// 使用mysql
			if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
				if (!mysql_select_db($argDb, $this->ConnID)) {
					echo '1:Could not use '.$argDb.' : '.mysql_error();
					exit;
				}
				$Ret = mysql_query($this->SqlStm, $this->ConnID);
				//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					$this->ErrorString=mysql_error();
					return 0;
				} else {
					$this->TableLock=1;
					return $Ret;
				}
			}
		   
			// 使用mssql
			if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1){
				$Ret=mssql_db_query($argDb,$this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					$this->ErrorString=mssql_error();
					return 0;
				} else {
					$this->TableLock=1;
					return $Ret;
				}
			}
		}           
	}
	
	function unlockTable($argDb,$TableCondition){
		if($TableCondition!=NULL){
			$this->SqlStm="UNLOCK TABLES";
			// 使用mysql
			if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1 and $this->TableLock){
				if (!mysql_select_db($argDb, $this->ConnID)) {
					echo '1:Could not use '.$argDb.' : '.mysql_error();
					exit;
				}
				$Ret = mysql_query($this->SqlStm, $this->ConnID);
				//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					$this->ErrorString=mysql_error();
					return 0;
				} else {  
					$this->TableLock=0;
					return $Ret;
				}
			}
		   
			// 使用mssql
			if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1 and $this->TableLock){
				$Ret=mssql_db_query($argDb,$this->SqlStm,$this->ConnID);
				if($Ret<=0){
					$this->ErrorCode=0;
					$this->ErrorString=mssql_error();
					return 0;
				} else {  
					$this->TableLock=0;
					return $Ret;
				}
			}
		}           
	}
	
	function TransactionStart($argDb){
		$this->SqlStm="START TRANSACTION";
		if (!mysql_select_db($argDb, $this->ConnID)) {
			echo '1:Could not use '.$argDb.' : '.mysql_error();
			exit;
		}
		$Ret = mysql_query($this->SqlStm, $this->ConnID);
		//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
		$this->ErrorString=mysql_error();
		// 使用mysql
		if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
			if($Ret<=0){
				$this->ErrorCode=0;
				$this->ErrorString=mysql_error();
				return 0;
			} else {
				return $Ret;
			}
		}
		 
		// 使用mssql
		if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1){
			if($Ret<=0){
				$this->ErrorCode=0;
				$this->ErrorString=mssql_error();
				return 0;
			} else {
				return $Ret;
			}
		}
	}
	
	function TransactionEnd($argDb){
		$this->SqlStm="COMMIT";
		if (!mysql_select_db($argDb, $this->ConnID)) {
			echo '1:Could not use '.$argDb.' : '.mysql_error();
			exit;
		}
		$Ret = mysql_query($this->SqlStm, $this->ConnID);
		//$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
		// 使用mysql
		if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
			if($Ret<=0){
				$this->ErrorCode=0;
				$this->ErrorString=mysql_error();
				return 0;
			} else {
				return $Ret;
			}
		}
		 
		// 使用mssql
		if($this->DbType==$this->MS_SQL_SERVER and $this->Status==1){
			if($Ret<=0){
				$this->ErrorCode=0;
				$this->ErrorString=mssql_error();
				return 0;
			} else {
				return $Ret;
			}
		}
	}

}

?>