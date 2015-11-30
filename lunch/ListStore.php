<?php

	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

	$Lnh = new LnhLnhCfactory(); 
  
   	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}

	// 內頁功能 (FORM)
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('TplBody'=>"ListStore.tpl"));
	$tpl->define_dynamic("row","TplBody");
  
	//產生本程式功能內容
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
	$SysPag->msg_total = $Lnh->GetAllStoreCount();
	$SysPag->max_rows = $maxRows; 
	$SysPag->max_pages= 10;

	$pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
	$pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
	$pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
	// Page Ended ************************************************ 
	$rows = $Lnh->GetAllStorePage($Status,$Name,$PayType,$startRow,$maxRows); //* Page *//
  	$row = mysql_fetch_assoc($rows);
  	if ($row == NULL) {
  		$tpl->assign('editstoreid',"");
		$tpl->assign('editdetails',"");
  		$tpl->assign('storename',"");
        $tpl->assign('tel',"");
        $tpl->assign('man',"");
        $tpl->assign('editdate',"");
        $tpl->assign('status',"");
        $tpl->parse('ROWS',"row");        
  	} else {
		//echo "<pre>";echo print_r($row);echo "</pre>";exit();
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
  			//$tpl->assign(editstoreid,"<a href='/lunch/EditStore.php?id=$row[RecordID]'>修改</a>");
  			$tpl->assign('storeid',$row['RecordID']);
  			if ($row['Status']==1) {
  				$tpl->assign('status',"正常");
				$tpl->assign('editdetails',"<a href='/lunch/PdsDetails.php?id=$row[RecordID]'>新增維護</a>");
  			} else {
  				$tpl->assign('status',"停用");
				$tpl->assign('editdetails',"新增維護");
  			}
  			
            //$tpl->assign(storename,"<a target='_blank' href='/lunch/StoreDetail.php?id=$row[RecordID]'>$row[StoreName]</a>");
            //$tpl->assign(storename,"<a target='_blank' href='javascript:window.open(\"/lunch/StoreDetail.php?id=$row[RecordID]\",\"sdetail\",\"height=400,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430\");'>$row[StoreName]</a>");
	        $tpl->assign('storename',"<a href='javascript:ShowDetail($row[RecordID]);'>$row[StoreName]</a>");
			//window.open("News2.htm","NEW2","height=260,width=400,left=0,scrollbars=no,location=0,status=0,menubar=0,top=430");
			$tpl->assign('tel',$row['Tel']);
            $tpl->assign('man',$row['MainMan']);
            $tpl->assign('editdate',date("Y-m-d",$row['EditDate']));
			
            $tpl->parse('ROWS',".row");         
			$row = mysql_fetch_assoc($rows);
  		}
  	}

	$tpl->assign('totalrows',"共 ".$Lnh->GetAllStoreCount()." 筆 "); //* Page *// 
	$tpl->assign('pageselect',$pagestr); //* Page *// 
	
	$tpl->parse('BODY',"TplBody");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str);
	$MainTpl->assign("LOCATION","店家維護");
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');

?>