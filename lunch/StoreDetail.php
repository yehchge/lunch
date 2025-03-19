<?php

declare(strict_types=1); // 嚴格類型

    header('Content-Type: text/html; charset=utf-8');
	defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();
	
	include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
	include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 

	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
	header("Expires: Tue, Jan 12 1999 05:00:00 GMT");
 
   $Lnh = new LnhLnhCfactory(); 

   	// 檢查使用者有沒有登入
	$Online = $Lnh->GetOnline();
	if(!$Online[0]) {
		header("Location:./Login.php");
  		return;
  	}
 
	$id = trim($_REQUEST['id']);
	
	//產生本程式功能內容
	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
	$tpl->define(array('apg6'=>"StoreDetail.tpl")); 
  
	$info = $Lnh->GetStoreDetailsByRecordID($id);
  
	$tpl->assign('storeid',$info['RecordID']);
	$tpl->assign('store',$info['StoreName']);
	$tpl->assign('intro',$info['StoreIntro']);
	$tpl->assign('sclass',$info['StoreClass']);
	$tpl->assign('man',$info['MainMan']);
	$tpl->assign('tel',$info['Tel']);
	$tpl->assign('addr',$info['Address']);
	$tpl->assign('createdate',date("Y-m-d",$info['CreateDate']));
	$tpl->assign('editdate',date("Y-m-d",$info['EditDate']));
	$tpl->assign('note',$info['Note']);
	if ($info['Status']==1) {
		$tpl->assign('status',"正常"); 
	} else {
		$tpl->assign('status',"停用");
	}
 
	$tpl->parse('MAIN',"apg6");
	$tpl->FastPrint('MAIN');
