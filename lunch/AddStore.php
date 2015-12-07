<?php

	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
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

	//產生本程式功能內容
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('apg6'=>"AddStore.tpl")); 
	$tpl->parse('BODY',"apg6");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","新增店家"); 
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');
  
?>