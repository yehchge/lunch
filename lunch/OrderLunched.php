<?php
	
	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCfactory.php"; 
	include_once "/usr/local/apache2/htdocs/ums/lib/UmsUmsCfactory.php";
	include_once "/usr/local/apache2/htdocs/gphplib/class.FastTemplate.php";
	
	$Lnh = new LnhLnhCfactory();
	$Ums = new UmsUmsCfactory();
	
   	// �ˬd�ϥΪ̦��S���n�J
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:/lunch/Login.php");
  		return;
  	}
	
	// �����\�� (FORM)
	$tpl = new FastTemplate("/usr/local/apache2/htdocs.lunch/lunch/tpl");
	$tpl->define(array(TplBody=>"OrderLunched.tpl"));
	$tpl->define_dynamic("row","TplBody");
	
	//echo "<pre>";echo print_r($Online);echo "</pre>";exit();
	$UserInfo = $Ums->GetUserInfoByAccount($Online[Account]);
	//echo "<pre>";echo print_r($UserInfo);echo "</pre>";exit();
	$chkid = $_POST["chk"];
	$ManagerID = $_POST["mid"];
	
	//CheckBox ���
	$i=0;
	$str = "�z�ҭq�ʪ��K����Ӧp�U�G<br>";
	$str .= "========================<br>";
	if (!$chkid) {
		$tpl->clear_dynamic("row");
		$tpl->parse(ROWS,".row"); 	
	} else {
		foreach ($chkid as $key => $value) {
			if ($i==0) {
				$class = "Forums_Item";
				$i=1;
			} else {
				$class = "Forums_AlternatingItem";
				$i=0;
			}
			$tpl->assign(classname,$class);
			$PdsID = $value;
			$Count = trim($_POST["cnt".$value]);
			$Note = trim($_POST["note".$value]);
			$info = $Lnh->GetPdsDetailsByRecordID($PdsID);
			//echo "<pre>";echo print_r($info);echo "</pre>";
			$PdsName = $info[PdsName];
			$Price = $info[Price];
			// �g�J�q�椤
			$ret = $Lnh->CreateOrder($ManagerID,$UserInfo[name],$PdsID,$PdsName,$Price,$Count,$Note,$Online[Account]);
			if ($ret) {
				$strret = "�q�ʦ��\!";
			} else {
				$strret = "����!";
			}
			//$str .= "�K��:$PdsName, ���:$Price, �ƶq:$Count,�Ƶ�:$Note, $strret<br>";
			$tpl->assign(pdsname,$PdsName);
			$tpl->assign(price,$Price);
			$tpl->assign(count,$Count);
			$tpl->assign(note,$Note);
			
			$tpl->parse(ROWS,".row"); 		
		}
	}
	
	if ($i==0) {
		$class = "Forums_Item";
		$i=1;
	} else {
		$class = "Forums_AlternatingItem";
		$i=0;
	}
	$tpl->assign(classname1,$class);
	
	//echo phpinfo();
	
	$tpl->parse(BODY,"TplBody");
	$str = $tpl->fetch(BODY);
	$MainTpl = new FastTemplate("/usr/local/apache2/htdocs.lunch/lunch/tpl");
	$MainTpl->define(array(apg=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","�q�K��/�q��GO/�q�ʫK���G"); 
	$MainTpl->parse(MAIN,"apg");
	$MainTpl->FastPrint(MAIN);
	

?>