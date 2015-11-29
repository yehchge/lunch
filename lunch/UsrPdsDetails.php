<?php

	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCfactory.php"; 
	include_once "/usr/local/apache2/htdocs/gphplib/class.FastTemplate.php";

	$Lnh = new LnhLnhCfactory(); 
 
   	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:/lunch/Login.php");
  		return;
  	}
 
	// 內頁功能 (FORM)
	$tpl = new FastTemplate("/usr/local/apache2/htdocs.lunch/lunch/tpl");
	$tpl->define(array(TplBody=>"UsrPdsDetails.tpl"));
	$tpl->define_dynamic("row","TplBody");
	
	//產生本程式功能內容
	// Page Start ************************************************ 
	include_once "/usr/local/apache2/htdocs/gphplib/SysPagCfactory.php"; 
	$page= $_REQUEST['page']; 
	$Status = 1; // 顯示正常狀態的資料
	$Name = $_REQUEST['Name'];
	$PayType = $_REQUEST['PayType'];
	$StoreID = $_REQUEST['id'];
  
	$tpl->assign(id,$StoreID);
  
	if(!$page) $page=1; 
	if(!$maxRows) $maxRows = 10; 
	$startRow = ($page-1)*$maxRows; 
	$SysPag = new SysPagCfactory(); 
	$SysPag->url="$PHP_SELF?1=1&Status=$Status&id=$StoreID&Name=$Name&PayType=$PayType&SysID=$SysID"; 
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
  		$tpl->assign(editpdsid,"");
		$tpl->assign(pdsid,"");
  		$tpl->assign(pdsname,"");
		$tpl->assign(pdstype,"");
        $tpl->assign(price,"");
        $tpl->assign(note,"");
        $tpl->assign(status,"");
        $tpl->parse(ROWS,"row");        
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
			$tpl->assign(classname,$class);

  			$tpl->assign(editpdsid,"<a href='/lunch/EditPds.php?id=$row[RecordID]&sid=$StoreID'>修改</a>");
  			$tpl->assign(pdsid,$row[RecordID]);
  			if ($row[Status]==1) {
  				$tpl->assign(status,"正常");
  			} else {
  				$tpl->assign(status,"停用");
  			}
  			
            $tpl->assign(pdsname,$row[PdsName]);
            $tpl->assign(pdstype,$row[PdsType]);
            $tpl->assign(price,$row[Price]);
			$tpl->assign(note,$row[Note]);
			
            $tpl->parse(ROWS,".row");         
			$row = mysql_fetch_assoc($rows);
  		}
  	}

	$tpl->assign(totalrows,"共 ".$Lnh->GetAllPdsCountByStore($StoreID,$Status)." 筆 "); //* Page *// 
	$tpl->assign(pageselect,$pagestr); //* Page *// 
	
	$tpl->parse(BODY,"TplBody");
	//$str = $tpl->fetch(BODY);
	$tpl->FastPrint(BODY);

?>
