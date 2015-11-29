<?php

	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCfactory.php"; 
	include_once "/usr/local/apache2/htdocs/gphplib/class.FastTemplate.php";
	include_once "/usr/local/apache2/htdocs.lunch/lunch/lib/LnhLnhCglobal.php"; 
  
	$Lnh = new LnhLnhCfactory();
	$LnhG = new LnhLnhCglobal();
	
   	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:/lunch/Login.php");
  		return;
  	}

	// 內頁功能 (FORM)
	$tpl = new FastTemplate("/usr/local/apache2/htdocs.lunch/lunch/tpl");
	$tpl->define(array(TplBody=>"OrderDetails.tpl"));
	$tpl->define_dynamic("row","TplBody");
  
	//產生本程式功能內容
	// Page Start ************************************************ 
	include_once "/usr/local/apache2/htdocs/gphplib/SysPagCfactory.php"; 
	$page= $_REQUEST['page']; 
	$Status = $_REQUEST['status']; ; // 只顯示訂購中
	$Name = $_REQUEST['Name'];
	$PayType = $_REQUEST['PayType'];
	$ManagerID = $_REQUEST['mid'];
  
	if(!$page) $page=1; 
	if(!$maxRows) $maxRows = 10; 
	$startRow = ($page-1)*$maxRows; 
	$SysPag = new SysPagCfactory(); 
	$SysPag->url="$PHP_SELF?1=1&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID&mid=$ManagerID"; 
	$SysPag->page=$page; 
	$SysPag->msg_total = $Lnh->GetOrderDetailsPageCountByManagerID($ManagerID,$Status,$PayType);
	$SysPag->max_rows = $maxRows; 
	$SysPag->max_pages= 10;

	$pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
	$pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
	$pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
	$pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
	// Page Ended ************************************************ 
 	$rows = $Lnh->GetOrderDetailsPageByManagerID($ManagerID,$Status,$PayType,$startRow,$maxRows); //* Page *//
  	$row = mysql_fetch_assoc($rows);
  	if ($row == NULL) {
  		$tpl->assign(orderid,"");
		$tpl->assign(managerid,$ManagerID);
		$tpl->assign(pdsname,"");
		$tpl->assign(count,"");
		$tpl->assign(price,"");
		$tpl->assign(man,"");
		$tpl->assign(note,"");
  		$tpl->assign(createdate,"");
        $tpl->assign(status,"");
		$tpl->assign(editstatus,"");
        $tpl->parse(ROWS,"row");        
  	} else {
		//echo "<pre>";echo print_r($row);echo "</pre>";
		$Minfo = $Lnh->GetManagerDetailsByRecordID($ManagerID);
		//echo "<pre>";echo print_r($Minfo);echo "</pre>";
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
  			$tpl->assign(orderid,$row[RecordID]);
			$tpl->assign(managerid,$ManagerID);
			$tpl->assign(pdsname,$row[PdsName]);
			$tpl->assign(count,$row[Count]);
			$tpl->assign(price,$row[Price]);
			$tpl->assign(man,$row[OrderMan]);
			$tpl->assign(note,$row[Note]);
			$tpl->assign(createdate,date("Y-m-d H:i:s",$row[CreateDate]));
			$info = $Lnh->GetStoreDetailsByRecordID($row[StoreID]);
			//echo "<pre>";echo print_r($info);echo "</pre>";
			if ($row[Status]==1) {
				$str = "正常";
			} else if ($row[Status]==2) {
				$str = "取消";
			} else if ($row[Status]==9) {
				$str = "刪除";
			} else {
				$str = "異常";
			}
			
			if ($Minfo[Status]==1) {
				$strStatus = "<a href='/lunch/EditOrder.php?id=$row[RecordID]&mid=$ManagerID'><img src='tpl/images/edit_s.gif' border='0'></a>";
			} else {
				$strStatus = "<img src='tpl/images/lock.gif' border='0'>";
			}
			$tpl->assign(status,$str);
			$tpl->assign(editstatus,$strStatus);
            $tpl->parse(ROWS,".row");         
			$row = mysql_fetch_assoc($rows);
  		}
  	}

	$tpl->assign(totalrows,"共 ".$Lnh->GetOrderDetailsPageCountByManagerID($ManagerID,$Status,$PayType)." 筆 "); //* Page *// 
	$tpl->assign(pageselect,$pagestr); //* Page *// 

	$tpl->parse(BODY,"TplBody");
	$str = $tpl->fetch(BODY);
	$MainTpl = new FastTemplate("/usr/local/apache2/htdocs.lunch/lunch/tpl");
	$MainTpl->define(array(apg=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","訂便當明細/訂購人明細"); 
	$MainTpl->parse(MAIN,"apg");
	$MainTpl->FastPrint(MAIN);

?>