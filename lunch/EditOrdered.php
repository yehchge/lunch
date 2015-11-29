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

	$RecordID = trim($_POST["orderid"]);
	$Status = trim($_POST["status"]);
	$ManagerID = trim($_POST["managerid"]);
	//echo $Status;exit();
  
	//產生本程式功能內容
	if ($Lnh->UpdateOrderStatusByRecordID($RecordID,$Status,$Online[Account])) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('更新狀態成功!');\r\n";
		echo "location='/lunch/OrderDetails.php?mid=$ManagerID';\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	} else {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('更新狀態失敗!');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	}	
	//echo "<a href='/lunch/OrderDetails.php?mid=$ManagerID'>回指定店家管理列表</a>";
  
?>
