<?php

    header('Content-Type: text/html; charset=Big5');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

	$Lnh = new LnhLnhCfactory();
	
	$UserName = trim($_POST["username"]);
	$Password = trim($_POST["password"]);
	
	//TODO:¼È®É
	$UserName = 'admin';
	$Password = 'admin';

	//$info = $Ums->GetUserInfoByAccount("root");
	if ($Lnh->LnhLogin($UserName,$Password)) {
		header("location:./index.php");
		return;
	} else {
		header("location:./LoginFail.php");
		return;
	}
?>