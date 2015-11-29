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
	
	$PdsName = trim($_POST["pdsname"]);
	$PdsType = trim($_POST["pdstype"]);
	$Price = trim($_POST["pdsprice"]);
	$Note = trim($_POST["pdsnote"]);
	$StoreID = trim($_POST["pdsid"]);
  
	//產生本程式功能內容
	if ($Lnh->CreateProduct($StoreID,$PdsName,$PdsType,$Price,$Online[Account],$Note)) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('新增便當成功!');\r\n";
		echo "location='/lunch/PdsDetails.php?id=$StoreID';\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	} else {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('新增便當失敗!');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	}
	//echo "<a href='/lunch/PdsDetails.php?id=$StoreID'>回上一頁</a>";
  
?>