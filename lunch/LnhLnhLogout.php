<?php

	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

    $Lnh = new LnhLnhCfactory();

	//└╦┤·мOз_ж│┼vнн? ****************
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
		return;
	}
	// *******************************

	//setcookie("LunchWhoIs","",0,"/",".taipei.gov.tw");
	setcookie("LunchWhoIs","",0,"/","");
	header("Location:./Login.php");
?>