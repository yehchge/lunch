<?php

declare(strict_types=1); // 嚴格類型

    header('Content-Type: text/html; charset=utf-8');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();
	
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
	
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

	$StoreID = trim($_REQUEST["id"]);
	$Url = trim($_REQUEST["Url"]);

	if ($Lnh->CreateManager($StoreID,$Online['Account'],'說明:系統指定')) {
		echo "<script>\r\n";
		echo "alert('指定便當商家成功!');\r\n";
		echo "location='$Url';\r\n";
		echo "</script>\r\n";
	} else {
		echo "<script>\r\n";
		echo "alert('指定便當商家失敗!');\r\n";
		echo "history.back();\r\n";
		echo "</script>\r\n";
	}
	//echo "<a href='$Url'>回便當明細維護</a>";
