<?php

    header('Content-Type: text/html; charset=Big5');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
  
	$Lnh = new LnhLnhCfactory();

  	// �ˬd�ϥΪ̦��S���n�J
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}
	$StoreName = trim($_POST["name"]);
	$StoreIntro = trim($_POST["intro"]);
	$StoreClass = trim($_POST["sclass"]);
	$MainMan = trim($_POST["man"]);
	$Address = trim($_POST["addr"]);
	$Tel = trim($_POST["tel"]);
	$Note = trim($_POST["note"]);

	//���ͥ��{���\�ऺ�e
	if ($Lnh->CreateStore('','',$StoreName,$StoreIntro,$StoreClass,$MainMan,$Tel,$Address,$Online['Account'],$Note)) {
		echo "<script>\r\n";
		echo "alert('�s�W���\!');\r\n";
		echo "history.back();\r\n";
		echo "</script>\r\n";
	} else {
	  	echo "<script>\r\n";
		echo "alert('�s�W����!');\r\n";
		echo "history.back();\r\n";
		echo "</script>\r\n";
	}
  
?>