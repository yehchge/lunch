<?php

	include_once "/usr/local/apache2/htdocs/gphplib/class.FastTemplate.php";
	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCfactory.php"; 
	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCglobal.php"; 

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
  
	$Lnh = new LnhLnhCfactory(); 
	$LnhG = new LnhLnhCglobal();

  	// �ˬd�ϥΪ̦��S���n�J
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:/lunch/Login.php");
  		return;
  	}
	//echo "<pre>";echo print_r($Online);echo "</pre>";
	$id = trim($_REQUEST['id']);
	
	//���ͥ��{���\�ऺ�e
	$tpl = new FastTemplate("/usr/local/apache2/htdocs.lunch/lunch/tpl");
	$tpl->define(array(apg6=>"EditManager.tpl")); 
  
	$info = $Lnh->GetManagerDetailsByRecordID($id);
	//echo "<pre>";echo print_r($info);echo "</pre>";
	
	// ����u���t�d�H�i�ק窱�A
	if (strcmp($Online[Account],$info[Manager])<>0) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('��! �u���t�d�H�i�ק�!�O�����!');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
		//echo "<br><a href='/lunch/ListAssignStore.php'>�^�W�@�B</a>";
		return;
	}
	
	$tpl->assign(managerid,$info[RecordID]);
	$tpl->assign(storeid,$info[StoreID]);
	$storeinfo = $Lnh->GetStoreDetailsByRecordID($info[StoreID]);
	//echo "<pre>";echo print_r($storeinfo);echo "</pre>";
	$tpl->assign(storename,$storeinfo[StoreName]);
	$tpl->assign(man,$info[Manager]);
	$tpl->assign(note,$info[Note]);
	$tpl->assign(createdate,date("Y-m-d H:i:s",$info[CreateDate]));
  
	$strStatus = "";
	foreach($LnhG->ManagerStatus as $key => $value) {
		//echo "key=".$key." , value=".$value;
		$strStatus .= "<option value='$key'>$value";
	}
	$tpl->assign(strStatus,$strStatus);
  
	$tpl->parse(BODY,"apg6");
	$str = $tpl->fetch(BODY);
	$MainTpl = new FastTemplate("/usr/local/apache2/htdocs.lunch/lunch/tpl");
	$MainTpl->define(array(apg=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","���w���a�޲z�B�I��B����/�޲z���w���a���A"); 
	$MainTpl->parse(MAIN,"apg");
	$MainTpl->FastPrint(MAIN);

  
	// ���DropDownList�]�w���A�O�d
	if (!empty($info[Status])) {echo "<script>seldroplist(this.frm.status,'".$info[Status]."');</script>";}
  
?>