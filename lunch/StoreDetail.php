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
 
	$id = trim($_REQUEST['id']);
	
	//���ͥ��{���\�ऺ�e
	$tpl = new FastTemplate("/usr/local/apache2/htdocs.lunch/lunch/tpl");
	$tpl->define(array(apg6=>"StoreDetail.tpl")); 
  
	$info = $Lnh->GetStoreDetailsByRecordID($id);
	//echo "<pre>";echo print_r($info);echo "</pre>";exit();
  
	$tpl->assign(storeid,$info[RecordID]);
	$tpl->assign(store,$info[StoreName]);
	$tpl->assign(intro,$info[StoreIntro]);
	$tpl->assign(sclass,$info[StoreClass]);
	$tpl->assign(man,$info[MainMan]);
	$tpl->assign(tel,$info[Tel]);
	$tpl->assign(addr,$info[Address]);
	$tpl->assign(createdate,date("Y-m-d",$info[CreateDate]));
	$tpl->assign(editdate,date("Y-m-d",$info[EditDate]));
	$tpl->assign(note,$info[Note]);
	if ($info[Status]==1) {
		$tpl->assign(status,"���`"); 
	} else {
		$tpl->assign(status,"����");
	}
 
	$tpl->parse(MAIN,"apg6");
	$tpl->FastPrint(MAIN);
  
?>
