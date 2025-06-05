<?php

declare(strict_types=1); // 嚴格類型

define('CI_START', microtime(true));

header('Content-Type: text/html; charset=utf-8');

require 'app/Config/Config.php';

require 'app/System/PageNotFoundException.php';
require 'app/System/SecurityException.php';
require 'app/System/FilterInterface.php';
require 'app/Security/CsrfFilter.php';
require 'app/System/FilterManager.php';
require 'app/System/Application.php';

$db = new Database();
$userRepo = new UserRepository($db);
$auth = new Auth($userRepo);

try{

    // $test = new DebugConsole();
    // $test->showDebugInfo(1);

    $app = new Application();
    $app->handleRequest();

    // // 產生本程式功能內容
    // $tpl = new Template("app/Views");



}catch (\Exception $e){
    echo $e->getMessage().PHP_EOL;
    exit;
}
