<?php

	include_once "/usr/local/apache2/htdocs/gphplib/class.FastTemplate.php";
	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCfactory.php";

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
  
	$Lnh = new LnhLnhCfactory();

  	// �ˬd�ϥΪ̦��S���n�J
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:/lunch/Login.php");
  		return;
  	}

	$RecordID = trim($_POST["orderid"]);
	$Status = trim($_POST["status"]);
	$ManagerID = trim($_POST["managerid"]);
	//echo $Status;exit();
  
	//���ͥ��{���\�ऺ�e
	if ($Lnh->UpdateOrderStatusByRecordID($RecordID,$Status,$Online[Account])) {
		echo "<script>\r\n";
		echo "<!--\r\n";
		echo "alert('��s���A���\!');\r\n";
		echo "location='/lunch/OrderDetails.php?mid=$ManagerID';\r\n";
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
	//echo "<a href='/lunch/OrderDetails.php?mid=$ManagerID'>�^���w���a�޲z�C��</a>";
  
?>
