<?php

    header('Content-Type: text/html; charset=Big5');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
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

	$RecordID = trim($_POST["managerid"]);
	$Status = trim($_POST["status"]);
  
	//���ͥ��{���\�ऺ�e
	if ($Lnh->UpdateManagerStatusByRecordID($RecordID,$Status)) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('��s���A���\!');\r\n";
		echo "location='./ListAssignStore.php';\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	} else {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('��s���A����!');\r\n";
		echo "history.back();\r\n";
		echo "//-->\r\n";
		echo "</script>\r\n";
	}
	//echo "<a href='./ListAssignStore.php'>�^���w���a�޲z�C��</a>";
  
?>