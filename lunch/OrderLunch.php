<?php

    header('Content-Type: text/html; charset=Big5');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

	$Lnh = new LnhLnhCfactory(); 
  
   	// �ˬd�ϥΪ̦��S���n�J
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}

	// �����\�� (FORM)
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('TplBody'=>"OrderLunch.tpl"));
	$tpl->define_dynamic("row","TplBody");
  
	//���ͥ��{���\�ऺ�e
	// Page Start ************************************************ 
	include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
	$page = isset($_REQUEST['page'])?$_REQUEST['page']:0; 
	$Status = 1; // ��ܥ��`���A�����
	$Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
	$PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
	$StoreID = isset($_REQUEST['id'])?$_REQUEST['id']:0;
	$ManagerID = isset($_REQUEST['mid'])?$_REQUEST['mid']:0;
	$SysID = 1;
  
	$tpl->assign('id',$StoreID);
	$tpl->assign('mid',$ManagerID);
  
	if(!$page) $page=1; 
	$maxRows = 10; 
	$startRow = ($page-1)*$maxRows; 
	$SysPag = new SysPagCfactory(); 
	$SysPag->url=$_SERVER['PHP_SELF']."?1=1&Status=$Status&id=$StoreID&Name=$Name&PayType=$PayType&SysID=$SysID"; 
	$SysPag->page=$page; 
	$SysPag->msg_total = $Lnh->GetAllPdsCountByStore($StoreID,$Status);
	$SysPag->max_rows = $maxRows; 
	$SysPag->max_pages= 10;

	$pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
	$pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
	$pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
	// Page Ended ************************************************ 
 	$rows = $Lnh->GetAllPdsPageByStore($StoreID,$Status,'',$startRow,$maxRows); //* Page *//
  	$row = mysql_fetch_assoc($rows);
  	if ($row == NULL) {
  		$tpl->assign('editpdsid',"");
		$tpl->assign('pdsid',"");
  		$tpl->assign('pdsname',"");
		$tpl->assign('pdstype',"");
        $tpl->assign('price',"");
        $tpl->assign('note',"");
        $tpl->assign('status',"");
        $tpl->parse('ROWS',"row");        
  	} else {
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
  			$tpl->assign('editpdsid',"<a href='./EditPds.php?id=".$row['RecordID']."&sid=$StoreID'>�ק�</a>");
  			$tpl->assign('pdsid',$row['RecordID']);
  			if ($row['Status']==1) {
  				$tpl->assign('status',"���`");
  			} else {
  				$tpl->assign('status',"����");
  			}
  			
            $tpl->assign('pdsname',$row['PdsName']);
            $tpl->assign('pdstype',$row['PdsType']);
            $tpl->assign('price',$row['Price']);
			$tpl->assign('note',$row['Note']);
			
            $tpl->parse('ROWS',".row");         
			$row = mysql_fetch_assoc($rows);
  		}
  	}

	$tpl->assign('totalrows',"�@ ".$Lnh->GetAllPdsCountByStore($StoreID,$Status)." �� "); //* Page *// 
	$tpl->assign('pageselect',$pagestr); //* Page *// 
	
	$tpl->parse('BODY',"TplBody");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str);
	$MainTpl->assign("LOCATION","�q�K��/�q��GO");
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');

?>