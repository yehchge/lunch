<?php

	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
	include_once PATH_ROOT."/lunch/lib/LnhLnhCglobal.php"; 
  
	$Lnh = new LnhLnhCfactory();
	$LnhG = new LnhLnhCglobal();
	
	// �ˬd�ϥΪ̦��S���n�J
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}
	
	// �����\�� (FORM)
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('TplBody'=>"ListAssignStore.tpl"));
	$tpl->define_dynamic("row","TplBody");
  
	//���ͥ��{���\�ऺ�e
	// Page Start ************************************************ 
	include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
	$page= isset($_REQUEST['page'])?$_REQUEST['page']:0; 
	$Status = isset($_REQUEST['Status'])?$_REQUEST['Status']:0;
	$Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
	$PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
	$SysID = 1;
  
	if(!$page) $page=1; 
	$maxRows = 10; 
	$startRow = ($page-1)*$maxRows; 
	$SysPag = new SysPagCfactory(); 
	$SysPag->url=$_SERVER['PHP_SELF']."?1=1&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID"; 
	$SysPag->page=$page; 
	$SysPag->msg_total = $Lnh->GetAllManagerCount();
	$SysPag->max_rows = $maxRows; 
	$SysPag->max_pages= 10;

	$pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
	$pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
	$pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
	// Page Ended ************************************************ 
 	$rows = $Lnh->GetAllManagerPage($Status,$PayType,$startRow,$maxRows); //* Page *//
  	$row = mysql_fetch_assoc($rows);
  	if ($row == NULL) {
  		$tpl->assign('managerid',"");
  		$tpl->assign('createdate',"");
		$tpl->assign('man',"");
		$tpl->assign('storeid',"");
        $tpl->assign('storename',"");
        $tpl->assign('status',"");
        $tpl->parse('ROWS',"row");        
  	} else {
		//echo "<pre>";echo print_r($row);echo "</pre>";
		$i=0;
  		while ($row != NULL) {
			if ($i==0) {
				$class = "Forums_Item";
				$i=1;
			} else {
				$class = "Forums_AlternatingItem";
				$i=0;
			}
			$tpl->assign('classname',$class);
  			$tpl->assign('managerid',$row['RecordID']);
			$tpl->assign('createdate',date("Y-m-d H:i:s",$row['CreateDate']));
			$tpl->assign('man',$row['Manager']);
  			$tpl->assign('storeid',$row['StoreID']);
			$info = $Lnh->GetStoreDetailsByRecordID($row['StoreID']);
			//echo "<pre>";echo print_r($info);echo "</pre>";
			$tpl->assign('storename',$info['StoreName']);
  			$tpl->assign('status',$LnhG->ManagerStatus[$row['Status']]);
            $tpl->parse('ROWS',".row");         
			$row = mysql_fetch_assoc($rows);
  		}
  	}

	$tpl->assign('totalrows',"�@ ".$Lnh->GetAllManagerCount()." �� "); //* Page *// 
	$tpl->assign('pageselect',$pagestr); //* Page *// 

	$tpl->parse('BODY',"TplBody");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","���w���a�޲z�B�I��B����"); 
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');

?>