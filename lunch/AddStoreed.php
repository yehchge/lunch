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
	//echo "<pre>";echo print_r($Online);echo "</pre>";exit();
	$StoreName = trim($_POST["name"]);
	$StoreIntro = trim($_POST["intro"]);
	$StoreClass = trim($_POST["sclass"]);
	$MainMan = trim($_POST["man"]);
	$Address = trim($_POST["addr"]);
	$Tel = trim($_POST["tel"]);
	$Note = trim($_POST["note"]);

	//���ͥ��{���\�ऺ�e
	if ($Lnh->CreateStore('','',$StoreName,$StoreIntro,$StoreClass,$MainMan,$Tel,$Address,$Online[Account],$Note)) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('�s�W���\! ');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	} else {
	  	echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('�s�W����! ');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	}
  
?>
