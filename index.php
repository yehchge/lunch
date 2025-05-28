<?php

declare(strict_types=1); // 嚴格類型

define('CI_START', microtime(true));

header('Content-Type: text/html; charset=utf-8');

require 'app/Config/Config.php';

$db = new Database();
$userRepo = new UserRepository($db);
$auth = new Auth($userRepo);

try{

    // $test = new DebugConsole();
    // $test->showDebugInfo(1);

    // 產生本程式功能內容
    $tpl = new Template("app/Views");

    $routes = require PATH_ROOT."/app/Config/Routes.php";
    $routes->dispatch();

}catch (\Exception $e){
    echo $e->getMessage().PHP_EOL;
    exit;
}
