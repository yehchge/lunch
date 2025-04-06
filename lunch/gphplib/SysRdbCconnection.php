<?php

declare(strict_types=1); // 嚴格類型

// echo "系統更新維護,請稍後!!"; exit();

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
    var $SqlStm;
    private PDO $pdo;
    private bool $debug;

    function __construct($arg1=NULL,$arg2=NULL,$arg3=NULL,$arg4=NULL,$arg5=NULL,$arg6=NULL,$arg7=NULL){
        $this->debug = true;
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


    function isConnected(){
        return $this->Status;
    }


    function setConnStr($argConnStr){
        if($this->Status==0){
            $this->ConnStr=$argConnStr;
            return 1;
        } else return 0;             
    }


    function getConnStr(){
        return $this->ConnStr;
    }


    function setConnDb($argConnDb){
        if($this->Status==0){
            $this->ConnDb=$argConnDb;
            return 1;
        } else return 0;
    }


    function getConnDb(){
        return $this->ConnDb;
    }

    function setConnUid($argConnUid){
        if($this->Status==0){
            $this->ConnUid=$argConnUid;
            return 1;
        } else return 0;
    }


    function getConnUid(){
        return $this->ConnUid;
    }


    function setConnPwd($argConnPwd){
        if($this->Status==0){
            $this->ConnPwd=$argConnPwd;
            return 1;
        } else return 0;
    }

    function getConnPwd(){
        return $this->ConnPwd;
    }


    function setConnPort($argConnPort){
        if($this->Status==0){
            $this->ConnPort=$argConnPort;
            return 1;
        } else return 0;
    }


    function getConnPort(){
        return $this->ConnPort;
    }

    function setConnHost($argConnHost){
        if($this->Status==0){
            $this->ConnHost=$argConnHost;
            return 1;
        } else return 0;
    }


    function getConnHost(){
        return $this->ConnHost;
    }

    function getStatus(){
        return $this->Status;
    }


    function setDbType($argDbType){
        if($this->Status==0){
            $this->DbType=$argDbType;
            return 1;
        } else return 0;
    }


    function getDbType(){
        return $this->DbType;
    }

    function activate(){
        if($this->DbType==$this->MY_SQL_SERVER){

            try{
                $temp = new PDO("mysql:host=".$this->ConnHost.";dbname=".$this->ConnDb.";charset=utf8", (string)$this->ConnUid, (string)$this->ConnPwd);
            }catch(PDOException $e){
                echo $e->getMessage();exit;
            }

            $temp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // if($temp>0){
                $this->Status=1;
                $this->ConnID=$temp;
                $this->pdo = $temp;
            // } else {
            //     $this->Status=0;
            //     header("http/1.0 404 Not Found"); 
            // }
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
            $this->ConnID->query("USE ".$argDb);
           
            $Result = $this->ConnID->query($this->SqlStm, $this->ConnID);
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
            $this->ConnID->query("USE ".$argDb);

            $temp = $this->ConnID->query($this->SqlStm);
            //$temp=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
            if(!$temp){
                $this->ErrorCode=0;
                $this->ErrorString=$this->ConnID->errorInfo();
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
                $this->ErrorString=$this->ConnID->errorInfo();
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


    function SqlSelect($argDb,$argTable,$argField,$argCondition){
        if($argCondition!=NULL)
            $this->SqlStm="select $argField from $argTable where $argCondition";
        else
            $this->SqlStm="select $argField from $argTable";
        // 使用mysql
        if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1) {
            $this->ConnID->query("USE ".$argDb);
            
            $Ret = $this->ConnID->query($this->SqlStm);
        
            //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);  
            return $Ret;
      
            if($Ret<=0) {
                $this->ErrorCode=0;
                $this->ErrorString=$this->ConnID->errorInfo();
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
     

    function SqlDataPageSelect($argDb,$argTable,$argField,$argCondition,$argRowsBegin=NULL,$argRows=NULL){
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
        $this->ConnID->query("USE ".$argDb);


        $Ret = $this->ConnID->query($this->SqlStm);
        //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID); 
        if(!$Ret){
            $this->ErrorCode=0;
            $this->ErrorString=$this->ConnID->errorInfo();
            return 0;
        } else {

          
            return $Ret;
        }
       
        if($Ret<=0){
            $this->ErrorCode=0;
            $this->ErrorString=$this->ConnID->errorInfo();
            return 0;
        } else {
            return $Ret;
        }
    }        


    function SqlInsert($argDb,$argTable,$argField,$argValues){
        if($argValues!=NULL){
            try{

                $this->SqlStm = "insert into $argTable ($argField) values ($argValues)"; 


                // 使用 mysql 
                if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){

                    $this->ConnID->query("USE ".$argDb);

                    $Ret = $this->ConnID->query($this->SqlStm);
                    //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
                    if($Ret<=0){
                        $this->ErrorCode=0;
                        $this->ErrorString=$this->ConnID->errorInfo();
                        return 0;
                    } else return $Ret;
                }


            }catch(PDOException $e){
                echo $e->getMessage();exit;
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


    private function handleError(string $message): void {
        if ($this->debug) {
            echo "DB Error: $message" . PHP_EOL;
        }
    }


    public function execute(string $sql, array $params = []): bool {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }

    public function insert(string $table, array $data): bool {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->execute($sql, array_values($data));
    }

    public function update(string $table, array $data, string $where, array $params): bool {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE $table SET $set WHERE $where";  
        return $this->execute($sql, array_merge(array_values($data), $params));
    }

    public function lastInsertId(): string {
        return $this->pdo->lastInsertId();
    }


    function SqlUpdate($argDb,$argTable,$argSetValue,$argCondition){
        if($argCondition!=NULL){
            $this->SqlStm="update $argTable set $argSetValue where $argCondition";
            // 使用 mysql
            if($this->DbType==$this->MY_SQL_SERVER and $this->Status=1){ 
                $this->ConnID->query("USE ".$argDb);

                $Ret = $this->ConnID->query($this->SqlStm);
                //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
                if($Ret<=0){
                    $this->ErrorCode=0;
                    $this->ErrorString=$this->ConnID->errorInfo();
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

    function SqlDelete($argDb,$argTable,$argCondition){
        if($argCondition!=NULL){     
            $this->SqlStm="delete from $argTable where $argCondition";
            // 使用mysql
            if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
                $this->ConnID->query("USE ".$argDb);

                $Ret = $this->ConnID->query($this->SqlStm);
                //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
                if($Ret<=0){
                    $this->ErrorCode=0;
                    $this->ErrorString=$this->ConnID->errorInfo();
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


    function fetch_array($argResult){
        if($argResult!=NULL) {
            // 使用 mysql
            if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
                return $argResult->fetch(PDO::FETCH_BOTH);
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


    function fetch_assoc($argResult){

        if($argResult!=NULL) {


            // 使用 mysql
            // if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
            // if($this->DbType==$this->MY_SQL_SERVER ){

                 $argResult->setFetchMode(PDO::FETCH_ASSOC);
                 return $argResult->fetch();
            // }
        
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
        } else {
            echo "Error :......<br>";
            return 0;
        }
    }

    
    function lockTable($argDb,$TableCondition){
        if($TableCondition!=NULL){
            $this->SqlStm="LOCK TABLES $TableCondition";
            // 使用mysql
            if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
                $this->ConnID->query("USE ".$argDb);

                $Ret = $this->ConnID->query($this->SqlStm);
                //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
                if($Ret<=0){
                    $this->ErrorCode=0;
                    $this->ErrorString=$this->ConnID->errorInfo();
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
                $this->ConnID->query("USE ".$argDb);

                $Ret = $this->ConnID->query($this->SqlStm);
                //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
                if($Ret<=0){
                    $this->ErrorCode=0;
                    $this->ErrorString=$this->ConnID->errorInfo();
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
        $this->ConnID->query("USE ".$argDb);

        $Ret = $this->ConnID->query($this->SqlStm);
        //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
        $this->ErrorString=$this->ConnID->errorInfo();
        // 使用mysql
        if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
            if($Ret<=0){
                $this->ErrorCode=0;
                $this->ErrorString=$this->ConnID->errorInfo();
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
        $this->ConnID->query("USE ".$argDb);

        $Ret = $this->ConnID->query($this->SqlStm);
        //$Ret=mysql_db_query($argDb,$this->SqlStm,$this->ConnID);
        // 使用mysql
        if($this->DbType==$this->MY_SQL_SERVER and $this->Status==1){
            if($Ret<=0){
                $this->ErrorCode=0;
                $this->ErrorString=$this->ConnID->errorInfo();
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
