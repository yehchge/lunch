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
 
  	// �ˬd�ϥΪ̦��S���n�J
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}

	$info = $Lnh->GetOrderDetailsByRecordID($id);
	//echo "<pre>";echo print_r($info);echo "</pre>";exit();
	
	// ����u���q�ʤH�i�ק窱�A
	if (strcmp($Online['Account'],$info['CreateMan'])<>0) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('��! �u���q�ʤH�i�ק�!�O�����!');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
		//echo "<br><a href='./ListAssignStore.php'>�^�W�@�B</a>";
		return;
	}	
	
	//���ͥ��{���\�ऺ�e
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
	$MainTpl->assign("LOCATION","�q�K�����/�q�ʤH����/�޲z�q�ʤH���Ӫ��A"); 
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');
  
	// ���DropDownList�]�w���A�O�d
	if (!empty($info['Status'])) {echo "<script>seldroplist(this.frm.status,'".$info['Status']."');</script>";}
  
?>