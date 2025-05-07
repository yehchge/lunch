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

    $router = new Router();

    $func = $router->func();
    $action = $router->action();
    $params = $router->params();

    // 產生本程式功能內容
    $tpl = new Template("app/Views");

    $routes = require PATH_ROOT."/app/Config/Routes.php";

    $sController = '';

    $requestUri = trim($func.'/'.$action, '/');

    $matched = false;

    foreach ($routes as $route => [$controller, $method, $needAuth]) {
        $pattern = "@^" . $route . "$@";
        if (preg_match($pattern, $requestUri, $matches)) {
            $matched = true;

            if ($needAuth) {
                // 檢查使用者有沒有登入
                if (!$auth->check()) {
                    $_SESSION['refer'] = $_SERVER['REQUEST_URI'] ?? '';
                    header("Location: ".BASE_URL."login");
                    exit;
                }
            }

            $controllerFile = PATH_ROOT."/app/Controller/{$controller}.php";
            if (file_exists($controllerFile)){
                //include, new target controller, and run method
                require_once $controllerFile; //include controller.php
                $instance = new $controller();  //new target controller

                if (method_exists($controller, $method)) {
                    call_user_func_array([$instance, $method], $params);
                    break;
                } else {
                    http_response_code(404);
                    echo "404 - Method '{$method}' not found.";
                }
            } else {
                http_response_code(404);
                echo "404 - Controller '{$controller}' not found.";
            }
        }

        elseif (preg_match("/\(:segment\)/i", $route)) {
            $matched = true;
            
            // if ($needAuth) {
            //     // 檢查使用者有沒有登入
            //     if (!$auth->check()) {
            //         $_SESSION['refer'] = $_SERVER['REQUEST_URI'] ?? '';
            //         header("Location: ".BASE_URL."login");
            //         exit;
            //     }
            // }

            $params = [$func];
            $controllerFile = PATH_ROOT."/app/Controller/{$controller}.php";
            if (file_exists($controllerFile)){
                //include, new target controller, and run method
                require_once $controllerFile; //include controller.php
                $instance = new $controller();  //new target controller

                if (method_exists($controller, $method)) {
                    call_user_func_array([$instance, $method], $params);
                    break;
                } else {
                    http_response_code(404);
                    echo "404 - Method '{$method}' not found.";
                }
            } else {
                http_response_code(404);
                echo "404 - Controller '{$controller}' not found.";
            }
        }
    }

    if (!$matched) {
        http_response_code(404);
        echo "404 Not Found";
    }
}catch (\Exception $e){
    echo $e->getMessage().PHP_EOL;
    exit;
}
