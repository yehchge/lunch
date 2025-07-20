<?php

declare(strict_types=1); // 嚴格類型

define('CI_START', microtime(true));

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';
require 'app/Config/Config.php';

use App\System\Application;

try {
    $app = new Application();
    $app->handleRequest();

    $session = session();

    // 記得這行要在「輸出 view 之前」呼叫，才能在這次請求結束前清除掉 flash
    register_shutdown_function(function () use ($session) {
        $session->clearFlashdata();
    });
} catch (\Exception $e) {
    // Log the error
    error_log($e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());

    // In a real application, you would log this error and show a user-friendly error page.
    if (getenv('APP_ENV') !== 'production') {
        echo 'Error: ' . $e->getMessage() . '<br>';
        echo 'File: ' . $e->getFile() . '<br>';
        echo 'Line: ' . $e->getLine() . '<br>';
    } else {
        http_response_code(500);
        echo '<h1>500 - Internal Server Error</h1>';
    }
    exit;
}
