<?php

declare(strict_types=1); // 嚴格類型

    header('Content-Type: text/html; charset=utf-8');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();
    
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 

	$Lnh = new LnhLnhCfactory(); 

   	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}
  
	// 內頁功能 (FORM)
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('TplBody'=>"PdsDetails.tpl"));
	$tpl->define_dynamic("row","TplBody");
	
	//產生本程式功能內容
	// Page Start ************************************************ 
	include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
	$page = isset($_REQUEST['page'])?$_REQUEST['page']:0; 
	$Status = isset($_REQUEST['Status'])?$_REQUEST['Status']:0;
	$Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
	$PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
	$StoreID = isset($_REQUEST['id'])?$_REQUEST['id']:0;
	$SysID = 1;
  
	$tpl->assign('id',$StoreID);
  
	if(!$page) $page=1; 
	$maxRows = 10; 
	$startRow = ($page-1)*$maxRows; 
	$SysPag = new SysPagCfactory(); 
	$SysPag->url=$_SERVER['PHP_SELF']."?1=1&id=$StoreID&Name=$Name&PayType=$PayType&SysID=$SysID"; 
	$SysPag->page=$page; 
	$SysPag->msg_total = $Lnh->GetAllPdsCountByStore($StoreID);
	$SysPag->max_rows = $maxRows; 
	$SysPag->max_pages= 10;

	$pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
	$pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
	$pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
	// Page Ended ************************************************ 
	$rows = $Lnh->GetAllPdsPageByStore($StoreID,'','',$startRow,$maxRows); //* Page *//
  	$row = $Lnh->fetch_assoc($rows);
  	if ($row == NULL) {
		$tpl->clear_dynamic("row");
		/*
  		$tpl->assign(editpdsid,"");
		$tpl->assign(pdsid,"");
  		$tpl->assign(pdsname,"");
		$tpl->assign(pdstype,"");
        $tpl->assign(price,"");
        $tpl->assign(note,"");
        $tpl->assign(status,"");
        $tpl->parse(ROWS,"row");    
		*/
  	} else {
		//echo "<pre>";echo print_r($row);echo "</pre>";exit();
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
  			$tpl->assign('storeid',$StoreID);
  			$tpl->assign('pdsid',$row['RecordID']);
  			if ($row['Status']==1) {
  				$tpl->assign('status',"正常");
  			} else {
  				$tpl->assign('status',"停用");
  			}
  			
            $tpl->assign('pdsname',$row['PdsName']);
            $tpl->assign('pdstype',$row['PdsType']);
            $tpl->assign('price',$row['Price']);
			$tpl->assign('note',$row['Note']);
			
            $tpl->parse('ROWS',".row");         
			$row = $Lnh->fetch_assoc($rows);
  		}
  	}

	$tpl->assign('totalrows',"共 ".$Lnh->GetAllPdsCountByStore($StoreID)." 筆 "); //* Page *// 
	$tpl->assign('pageselect',$pagestr); //* Page *// 

	$tpl->parse('BODY',"TplBody");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","店家維護/便當明細維護"); 
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');
