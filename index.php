<?php

declare(strict_types=1); // 嚴格類型

define('CI_START', microtime(true));

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';
require 'app/Config/Config.php';

use App\System\Database;
use App\Repository\UserRepository;
use App\Auth\Auth;
use App\System\Application;
use App\System\DebugConsole;

$db = new Database();
$userRepo = new UserRepository($db);
$auth = new Auth($userRepo);

try{

    $test = new DebugConsole();
    $test->showDebugInfo(0);

    $app = new Application();
    $app->handleRequest();

    $session = session();

    // 記得這行要在「輸出 view 之前」呼叫，才能在這次請求結束前清除掉 flash
    register_shutdown_function(function () use ($session) {
        $session->clearFlashdata();
    });

}catch (\Exception $e){
    echo $e->getMessage().PHP_EOL;
    exit;
}
