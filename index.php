<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');

require 'app/Config/Config.php';

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

    // $test = new DebugConsole();
    // $test->showDebugInfo(1);

    $func = $_GET['func'] ?? '';
    $action = $_GET['action'] ?? '';

    //產生本程式功能內容
    $tpl = new Template("app/Views");

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

    
    $tpl->assign('title', 'DinBenDon系統');
    $tpl->assign('breadcrumb', 'DinBenDon首頁');
    $tpl->display('body.htm');

}catch (\Exception $e){
    echo $e->getMessage().PHP_EOL;
    exit;
}