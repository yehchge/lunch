<?php

	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
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

	$StoreID = trim($_REQUEST["id"]);
	$Url = trim($_REQUEST["Url"]);

	if ($Lnh->CreateManager($StoreID,$Online['Account'],'����:�t�Ϋ��w')) {
		echo "<script>\r\n";
		echo "alert('���w�K��Ӯa���\!');\r\n";
		echo "location='$Url';\r\n";
		echo "</script>\r\n";
	} else {
		echo "<script>\r\n";
		echo "alert('���w�K��Ӯa����!');\r\n";
		echo "history.back();\r\n";
		echo "</script>\r\n";
	}
	//echo "<a href='$Url'>�^�K����Ӻ��@</a>";

?>