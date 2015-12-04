<?php

	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
	include_once PATH_ROOT."/lunch/lib/LnhLnhCglobal.php"; 

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
  
	$Lnh = new LnhLnhCfactory(); 
	$LnhG = new LnhLnhCglobal();

	$id = trim($_REQUEST['id']);
	$ManagerID = trim($_REQUEST['mid']);
 
  	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}

	$info = $Lnh->GetOrderDetailsByRecordID($id);
	//echo "<pre>";echo print_r($info);echo "</pre>";exit();
	
	// 限制只有訂購人可修改狀態
	if (strcmp($Online['Account'],$info['CreateMan'])<>0) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('ㄟ! 只有訂購人可修改!別偷改喔!');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
		//echo "<br><a href='./ListAssignStore.php'>回上一步</a>";
		return;
	}	
	
	//產生本程式功能內容
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('apg6'=>"EditOrder.tpl")); 
  
	$tpl->assign('orderid',$id);
	$tpl->assign('managerid',$ManagerID);
	$tpl->assign('orderman',$info['OrderMan']);
	$tpl->assign('pdsname',$info['PdsName']);
	$tpl->assign('price',$info['Price']);
	$tpl->assign('count',$info['Count']);
	$tpl->assign('note',$info['Note']);
	$tpl->assign('createdate',date("Y-m-d",$info['CreateDate']));
  
	/*
	$strStatus = "";
	foreach($LnhG->ManagerStatus as $key => $value) {
		$strStatus .= "<option value='$key'>$value";
	}
	$tpl->assign('strStatus',$strStatus);
	*/
	
	$tpl->parse('BODY',"apg6");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","訂便當明細/訂購人明細/管理訂購人明細狀態"); 
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');
  
	// 選擇DropDownList設定狀態保留
	if (!empty($info['Status'])) {echo "<script>seldroplist(this.frm.status,'".$info['Status']."');</script>";}
  
?>