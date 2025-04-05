<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');

require '../app/Config/Config.php';

$db = new Database();
$userRepo = new UserRepository($db);
$auth = new Auth($userRepo);

try{
    // 檢查使用者有沒有登入
    if (!$auth->check()) {
        $_SESSION['refer'] = $_SERVER['REQUEST_URI'];
        header("Location: ./login.php");
        exit;
    }

    $func = $_GET['func'] ?? '';
    $action = $_GET['action'] ?? '';

    //產生本程式功能內容
    $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
    $tpl->define(array('apg6'=>"index.htm"));

    require PATH_ROOT.'/app/Config/Routes.php';
    
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