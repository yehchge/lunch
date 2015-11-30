<?php

	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	//echo PATH_ROOT;exit;

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

	//產生本程式功能內容
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('apg6'=>"LunchMain.tpl")); 
	$tpl->assign("FUNCTION","");
	$tpl->assign("LOCATION","訂便當首頁");
	$tpl->parse('MAIN',"apg6");
	$tpl->FastPrint('MAIN');
?>