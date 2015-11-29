<?php

	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCfactory.php";

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

    $Lnh = new LnhLnhCfactory();

	//└╦┤·мOз_ж│┼vнн? ****************
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:/lunch/Login.php");
		return;
	}
	// *******************************

	setcookie("LunchWhoIs","",0,"/",".plusgroup.com.tw");
	header("Location:/lunch/Login.php");
?>