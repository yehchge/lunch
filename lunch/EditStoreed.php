<?php

	include_once "/usr/local/apache2/htdocs/gphplib/class.FastTemplate.php";
	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCfactory.php";

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
  
	$Lnh = new LnhLnhCfactory();

   	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:/lunch/Login.php");
  		return;
  	}

	$RecordID = trim($_POST["storeid"]);
	$StoreName = trim($_POST["sname"]);
	$StoreIntro = trim($_POST["intro"]);
	$StoreClass = trim($_POST["sclass"]);
	$MainMan = trim($_POST["man"]);
	$Address = trim($_POST["addr"]);
	$Tel = trim($_POST["tel"]);
	$Note = trim($_POST["note"]);
	$status = trim($_POST["status"]);
  
	if ($status=="on") {$cancel=2;} else {$cancel=1;}
	
	//產生本程式功能內容
	if ($Lnh->UpdateStore($RecordID,'','',$StoreName,$StoreIntro,$StoreClass,$MainMan,$Tel,$Address,$Online[Account],$Note,$cancel)) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('更新成功! ');\r\n";
		echo "location='/lunch/ListStore.php';\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	} else {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('更新失敗! ');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	}
	//echo "<a href='/lunch/ListStore.php'>回店家列表</a>";
  
?>
