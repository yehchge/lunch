<?php

    header('Content-Type: text/html; charset=Big5');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
  
	$Lnh = new LnhLnhCfactory(); 

   	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}

	$id = trim($_REQUEST['id']);
	$sid = trim($_REQUEST['sid']); 
 
	//產生本程式功能內容
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('apg6'=>"EditPds.tpl")); 
  
	$info = $Lnh->GetPdsDetailsByRecordID($id);
	$tpl->assign('pdsid',$id);
	$tpl->assign('sid',$sid);
	$tpl->assign('pdsid',$info['RecordID']);
	$tpl->assign('pdsname',$info['PdsName']);
	$tpl->assign('pdstype',$info['PdsType']);
	$tpl->assign('price',$info['Price']);
	$tpl->assign('note',$info['Note']);
	if ($info['Status']==1) {
		$tpl->assign('status',"");
	} else {
		$tpl->assign('status',"checked");
	}
  
	$tpl->parse('BODY',"apg6");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","店家維護/便當明細維護/更新便當明細"); 
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');
  
	// 選擇DropDownList設定狀態保留
	if (!empty($info['StoreClass'])) {echo "<script>seldroplisttext(this.frm.sclass,'".$info['StoreClass']."');</script>";}
  
?>