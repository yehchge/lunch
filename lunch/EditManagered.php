<?php

    header('Content-Type: text/html; charset=Big5');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
  
	$Lnh = new LnhLnhCfactory();

  	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}

	$RecordID = trim($_POST["managerid"]);
	$Status = trim($_POST["status"]);
  
	//產生本程式功能內容
	if ($Lnh->UpdateManagerStatusByRecordID($RecordID,$Status)) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('更新狀態成功!');\r\n";
		echo "location='./ListAssignStore.php';\r\n";
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
	//echo "<a href='./ListAssignStore.php'>回指定店家管理列表</a>";
  
?>