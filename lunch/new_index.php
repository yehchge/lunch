<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');

require '../app/Config/Config.php';
require PATH_ROOT."/app/System/Template.php";

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
    $tpl = new Template("tpl");

    $routes = [
        'store' => 'CStore',
        'product' => 'CProduct',
        'manager' => 'CManager',
        'order' => 'COrder',
    ];

    $func = $_GET['func'] ?? '';
    $action = $_GET['action'] ?? '';

    $sController = $routes[$func] ?? '';

    if($sController!==''){
        //include, new target controller, and run tManager
        include_once(PATH_ROOT."/app/Controller/$sController.php"); //include controller.php
        $oController = new $sController();  //new target controller
        return $oController->tManager();   //call controller entry function
    } else {
        // $tpl->assign("FUNCTION", '');
    }

    if ($func=='product' && $action=='list') {
        $breadCrumb = '店家明細維護';
    }

    if ($func=='product' && $action=='edit') {
        $breadCrumb = '店家維護/便當明細維護/更新便當明細';
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

    // $tpl->assign("LOCATION", $breadCrumb);
    // $tpl->parse('MAIN',"apg6");
    // $tpl->FastPrint('MAIN');
    
    $tpl->assign('title', 'DinBenDon系統');
    $tpl->assign('breadcrumb', 'DinBenDon首頁');
    $tpl->display('body.htm');

}catch (\Exception $e){
    echo $e->getMessage().PHP_EOL;
    exit;
}