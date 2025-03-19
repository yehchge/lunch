<?php

declare(strict_types=1); // 嚴格類型

    header('Content-Type: text/html; charset=utf-8');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));


require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();
	

	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
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
	$StoreName = trim($_POST["name"]);
	$StoreIntro = trim($_POST["intro"]);
	$StoreClass = trim($_POST["sclass"]);
	$MainMan = trim($_POST["man"]);
	$Address = trim($_POST["addr"]);
	$Tel = trim($_POST["tel"]);
	$Note = trim($_POST["note"]);

	//產生本程式功能內容
	if ($Lnh->CreateStore('','',$StoreName,$StoreIntro,$StoreClass,$MainMan,$Tel,$Address,$Online['Account'],$Note)) {
		echo "<script>\r\n";
		echo "alert('新增成功!');\r\n";
		echo "history.back();\r\n";
		echo "</script>\r\n";
	} else {
	  	echo "<script>\r\n";
		echo "alert('新增失敗!');\r\n";
		echo "history.back();\r\n";
		echo "</script>\r\n";
	}
