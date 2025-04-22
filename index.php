<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');

require 'app/Config/Config.php';

$db = new Database();
$userRepo = new UserRepository($db);
$auth = new Auth($userRepo);

try{

    // $test = new DebugConsole();
    // $test->showDebugInfo(1);

    $router = new Router();

    $func = $router->func();
    $action = $router->action();
    $params = $router->params();

    // 產生本程式功能內容
    $tpl = new Template("app/Views");

    $routes = [
        '' => ['', true], // 需要登入
        'store' => ['CStore', true],
        'product' => ['CProduct', true],
        'manager' => ['CManager', true],
        'order' => ['COrder', true],
        'login' => ['CLogin', false],  // 不需要登入
        'logout' => ['CLogout', false] // 不需要登入
    ];

    $sController = '';

    foreach ($routes as $route => [$controller, $needAuth]) {
        if($route==$func){
            if($needAuth){
                // 檢查使用者有沒有登入
                if (!$auth->check()) {
                    $_SESSION['refer'] = $_SERVER['REQUEST_URI'] ?? '';
                    header("Location: ".BASE_URL."login");
                    exit;
                }                
            }
            $sController = $controller;
        }
    }

    if($sController!==''){
        $controllerFile = PATH_ROOT."/app/Controller/$sController.php";
        if (file_exists($controllerFile)){
            //include, new target controller, and run method
            require_once $controllerFile; //include controller.php
            $oController = new $sController();  //new target controller

            if (method_exists($oController, $action)) {
                return call_user_func_array([$oController, $action], $params);
            } else {
                http_response_code(404);
                echo "404 - Method '{$action}' not found.";
            }
        } else {
            http_response_code(404);
            echo "404 - Controller '{$func}' not found.";
        }
        
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