<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
// echo PATH_ROOT;exit;

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();
// $dot = new DotEnv(PATH_ROOT . '/.env');
// $dot->load();

// echo getenv('LUNCH_ENV');echo "<br>";
// echo getenv("DATABASE_HOST");exit;

include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";
include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

$Lnh = new LnhLnhCfactory();

try{
    // 檢查使用者有沒有登入
    $Online = $Lnh->GetOnline();

    if(!$Online[0]) {
        header("Location:./login.php");
        return;
    }

    $func = $_GET['func'] ?? '';
    $action = $_GET['action'] ?? '';

    switch($func){
        case 'store':
            $sController = 'CStore';
            break;
        case 'product':
            $sController = 'CProduct';
            break;
        case 'manager':
            $sController = 'CManager';
            break;
        case 'order':
            $sController = 'COrder';
            break;
        default:
            $sController = '';
            break;
    }

    //產生本程式功能內容
    $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
    $tpl->define(array('apg6'=>"index.htm"));

    if($sController!==''){
        //include, new target controller, and run tManager
        include_once("../app/Controller/$sController.php"); //include controller.php
        $oController = new $sController();  //new target controller
        $tpl->assign("FUNCTION", $oController->tManager());   //call controller entry function
    } else {
        $tpl->assign("FUNCTION", '');
    }

    $breadCrumb = 'DinBenDon首頁';

    if ($func=='store' && $action=='add') {
        $breadCrumb = '新增店家';
    }

    if ($func=='store' && $action=='list') {
        $breadCrumb = '店家維護';
    }

    if ($func=='store' && $action=='edit') {
        $breadCrumb = '店家維護/更新店家';
    }

    if ($func=='product' && $action=='list') {
        $breadCrumb = '店家明細維護';
    }

    if ($func=='product' && $action=='edit') {
        $breadCrumb = '店家維護/便當明細維護/更新便當明細';
    }

    if ($func=='store' && $action=='assign') {
        $breadCrumb = '指定店家';
    }

    if ($func=='store' && $action=='list_assign') {
        $breadCrumb = '指定店家管理、截止、取消';
    }

    if ($func=='store' && $action=='edit_status') {
        $breadCrumb = '指定店家管理、截止、取消/管理指定店家狀態';
    }

    if ($func=='manager' && $action=='list') {
        $breadCrumb = 'DinBenDon';
    }

    if ($func=='order' && $action=='add' && strtoupper($_SERVER['REQUEST_METHOD'])=='GET') {
        $breadCrumb = 'DinBenDon/訂購GO';
    }

    if ($func=='order' && $action=='add' && strtoupper($_SERVER['REQUEST_METHOD'])=='POST') {
        $breadCrumb = 'DinBenDon/訂購GO/訂購便當結果';
    }

    if ($func=='order' && $action=='list') {
        $breadCrumb = 'DinBenDon明細/訂購人明細';
    }

    if ($func=='order' && $action=='edit') {
        $breadCrumb = 'DinBenDon明細/訂購人明細/管理訂購人明細狀態';
    }

    if ($func=='manager' && $action=='list_order') {
        $breadCrumb = 'DinBenDon明細';
    }

    $tpl->assign("LOCATION", $breadCrumb);
    $tpl->parse('MAIN',"apg6");
    $tpl->FastPrint('MAIN');
}catch (\Exception $e){
    echo $e->getMessage().PHP_EOL;
    exit;
}