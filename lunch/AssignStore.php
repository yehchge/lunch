<?php

declare(strict_types=1); // 嚴格類型

    header('Content-Type: text/html; charset=utf-8');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();
    
    include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

	$Lnh = new LnhLnhCfactory();



  	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}


	// 內頁功能 (FORM)
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('TplBody'=>"AssignStore.tpl"));
	$tpl->define_dynamic("row","TplBody");


	//產生本程式功能內容
	// Page Start ************************************************ 
	include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
	$page = isset($_REQUEST['page'])?$_REQUEST['page']:0; 
	$Status = 1; // 正常狀態才顯示
	$Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
	$PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
	$id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
	$SysID = 1;
	if(!$page) $page=1; 
	$maxRows = 10; 
	$startRow = ($page-1)*$maxRows; 
	$SysPag = new SysPagCfactory(); 
	$SysPag->url=$_SERVER['PHP_SELF']."?1=1&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID"; 
	$SysPag->page=$page; 
	


    $SysPag->msg_total = $Lnh->GetAllStoreCount($Status);
	$SysPag->max_rows = $maxRows; 
	$SysPag->max_pages= 10;


	$pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
	$pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
	$pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
	// Page Ended ************************************************ 


    $rows = $Lnh->GetAllStorePage($Status,$Name,$PayType,$startRow,$maxRows); //* Page *//
  	$row = $Lnh->fetch_assoc($rows);
  	if ($row == NULL) {
  		$tpl->assign('editstoreid',"");
  		$tpl->assign('storename',"");
        $tpl->assign('tel',"");
        $tpl->assign('man',"");
        $tpl->assign('editdate',"");
        $tpl->assign('status',"");
        $tpl->parse('ROWS',"row");        
  	} else {
		$i=0;
  		while ($row != NULL) {
			if ($i==0) {
				$class = "Forums_Item";
				$i=1;
			} else {
				$class = "Forums_AlternatingItem";
				$i=0;
			}
			$tpl->assign('classname',$class);
  			$tpl->assign('editstoreid',"<a href='".$_SERVER['PHP_SELF']."?1=1&Status=$Status&page=$page&Name=$Name&PayType=$PayType&SysID=$SysID&id=".$row['RecordID']."'>指定</a>");
  			$tpl->assign('storeid',$row['RecordID']);
  			if ($row['Status']==1) {
  				$tpl->assign('status',"正常");
  			} else {
  				$tpl->assign('status',"停用");
  			}
  			
            //$tpl->assign('storename',"<a target='_blank' href='/lunch/StoreDetail.php?id=$row[RecordID]'>$row[StoreName]</a>");
   	        $tpl->assign('storename',"<a href='javascript:ShowDetail($row[RecordID]);'>$row[StoreName]</a>");
			$tpl->assign('tel',$row['Tel']);
            $tpl->assign('man',$row['MainMan']);
            $tpl->assign('editdate',date("Y-m-d",$row['EditDate']));
			
            $tpl->parse('ROWS',".row");         
			$row = $Lnh->fetch_assoc($rows);
  		}
  	}

	$tpl->assign('totalrows',"共 ".$Lnh->GetAllStoreCount($Status)." 筆 "); //* Page *// 
	$tpl->assign('pageselect',$pagestr); //* Page *// 

	$tpl->parse('BODY',"TplBody");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str);
	$MainTpl->assign("LOCATION","指定店家");
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');
	
	if ($id) {
		echo "<Script>\r\n";
		echo "yy=confirm('今日確定要訂購此間店的便當嗎?');\r\n";
		echo "if (yy==0) {history.back();}\r\n";
		echo " else {location='./AssignStoreed.php?id=$id&Url=".$_SERVER["REQUEST_URI"]."';}\r\n";
		echo "</Script>\r\n";
		return;
	}  
