<?php
	
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
	//include_once PATH_ROOT."/ums/lib/UmsUmsCfactory.php";
	
	$Lnh = new LnhLnhCfactory();
	//$Ums = new UmsUmsCfactory();
	
   	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}
	
	// 內頁功能 (FORM)
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('TplBody'=>"OrderLunched.tpl"));
	$tpl->define_dynamic("row","TplBody");
	
	//$UserInfo = $Ums->GetUserInfoByAccount($Online['Account']);
	$UserInfo['name'] = 'John';
	$chkid = $_POST["chk"];
	$ManagerID = $_POST["mid"];
	
	//CheckBox 抓值
	$i=0;
	$str = "您所訂購的便當明細如下：<br>";
	$str .= "========================<br>";
	if (!$chkid) {
		$tpl->clear_dynamic("row");
		$tpl->parse(ROWS,".row"); 	
	} else {
		foreach ($chkid as $key => $value) {
			if ($i==0) {
				$class = "Forums_Item";
				$i=1;
			} else {
				$class = "Forums_AlternatingItem";
				$i=0;
			}
			$tpl->assign('classname',$class);
			$PdsID = $value;
			$Count = trim($_POST["cnt".$value]);
			$Note = trim($_POST["note".$value]);
			$info = $Lnh->GetPdsDetailsByRecordID($PdsID);
			$PdsName = $info['PdsName'];
			$Price = $info['Price'];
			// 寫入訂單中
			$ret = $Lnh->CreateOrder($ManagerID,$UserInfo['name'],$PdsID,$PdsName,$Price,$Count,$Note,$Online['Account']);
			if ($ret) {
				$strret = "訂購成功!";
			} else {
				$strret = "失敗!";
			}
			//$str .= "便當:$PdsName, 單價:$Price, 數量:$Count,備註:$Note, $strret<br>";
			$tpl->assign('pdsname',$PdsName);
			$tpl->assign('price',$Price);
			$tpl->assign('count',$Count);
			$tpl->assign('note',$Note);
			
			$tpl->parse('ROWS',".row"); 		
		}
	}
	
	if ($i==0) {
		$class = "Forums_Item";
		$i=1;
	} else {
		$class = "Forums_AlternatingItem";
		$i=0;
	}
	$tpl->assign('classname1',$class);
	
	$tpl->parse('BODY',"TplBody");
	$str = $tpl->fetch('BODY');
	$MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$MainTpl->define(array('apg'=>"LunchMain.tpl")); 
	$MainTpl->assign("FUNCTION",$str); 
	$MainTpl->assign("LOCATION","訂便當/訂購GO/訂購便當結果"); 
	$MainTpl->parse('MAIN',"apg");
	$MainTpl->FastPrint('MAIN');
	

?>