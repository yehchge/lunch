<?php

	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	//echo PATH_ROOT;exit;

	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

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

	//���ͥ��{���\�ऺ�e
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('apg6'=>"LunchMain.tpl")); 
	$tpl->assign("FUNCTION","");
	$tpl->assign("LOCATION","�q�K����");
	$tpl->parse('MAIN',"apg6");
	$tpl->FastPrint('MAIN');
?>