<?php

	include_once "/usr/local/apache2/htdocs/gphplib/class.FastTemplate.php";
	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCfactory.php";

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
  
	$Lnh = new LnhLnhCfactory();
 
	// �ˬd�ϥΪ̦��S���n�J
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:/lunch/Login.php");
  		return;
  	}

	$RecordID = trim($_POST["pdsid"]);
	$StoreID = trim($_POST["sid"]);
	$PdsName = trim($_POST["pdsname"]);
	$PdsType = trim($_POST["pdstype"]);
	$Price = trim($_POST["price"]);
	$Tel = trim($_POST["tel"]);
	$Note = trim($_POST["note"]);
	$status = trim($_POST["status"]);
  
	if ($status=="on") {$cancel=2;} else {$cancel=1;}
	
	//���ͥ��{���\�ऺ�e
	if ($Lnh->UpdateProduct($RecordID,$StoreID,$PdsName,$PdsType,$Price,$Online[Account],$Note,$cancel)) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('��s�K����Ӧ��\!');\r\n";
		echo "location='/lunch/PdsDetails.php?id=$StoreID';\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	} else {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('��s�K����ӥ���!');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	}
	//echo "<a href='/lunch/PdsDetails.php?id=$StoreID'>�^�K����Ӻ��@</a>";
  
?>
