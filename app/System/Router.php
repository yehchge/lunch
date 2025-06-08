<?php

namespace App\System;

class Router
{
    protected array $routes = [];

    public function get(string $path, $handler, array $middleware = []) {
        $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, $handler, array $middleware = []) {
        $this->addRoute('POST', $path, $handler, $middleware);
    }

    public function put(string $path, $handler, array $middleware = []) {
        $this->addRoute('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, $handler, array $middleware = []) {
        $this->addRoute('DELETE', $path, $handler, $middleware);
    }

    protected function addRoute(string $method, string $path, $handler, array $middleware)
    {
        $this->routes[$method][] = [
            'path' => $path,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function dispatch()
    {
        global $auth;
        
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $path = '/' . ltrim(substr($uri, strlen($base)), '/');
        $path = '/' . trim($path, '/');

        // 檢測是否有此方法
        if (!isset($this->routes[$method])) {
            http_response_code(405);
            exit("405 Method Not Allowed");
        }

        // Modern 嘗試現代路由匹配
        if (isset($this->routes[$method])){
            foreach ($this->routes[$method] as $route) {
                $pattern = preg_replace('#\(:segment\)#', '([^/]+)', $route['path']);
                $pattern = '#^/' . trim($pattern, '/') . '$#';

                if (preg_match($pattern, $path, $matches)) {
                    array_shift($matches);

                    [$controller, $action] = $this->resolveHandler($route['handler'], $matches);

                    // 中介軟體處理
                    foreach ($route['middleware'] as $middlewareClass) {
                        $middleware = new $middlewareClass();
                        if (method_exists($middleware, 'handle')) {
                            $middleware->handle(); // 可自定義跳轉或拋出異常
                        }
                    }

                    // 載入控制器並執行
                    // require_once PATH_ROOT . "/app/Controllers/{$controller}.php";
                    // use App\Controllers\$controller;

                    $controllerName = $controller;
                    $fullyQualifiedClass = "App\\Controllers\\{$controllerName}";

                    $instance = new $fullyQualifiedClass();
                    foreach ($matches as $key => $val) {
                        $matches[$key] = urldecode($val);
                    }
                    return call_user_func_array([$instance, $action], $matches);
                }
            }
        }


        // Classic 現代路由未匹配，嘗試舊式 URL 解析
        $params = [];
        $controller = '';
        $action = '';

        // 檢查是否有舊式 GET 參數
        if (!empty($_GET['func']) || !empty($_GET['action'])) {
            // 有舊網址參數 $_GET['func'] or $_GET['action']
            $controller = $_GET['func'] ?? 'home';
            $action = $_GET['action'] ?? 'index';
            foreach ($_GET as $key => $value) {
                if (!in_array($key, ['func', 'action'])) {
                    $params[] = $value;
                }
            }
        } else {
            // 沒有舊網址參數
            // index.php/about/contact/1234
            // /about/contact/1234
            // /專案名稱/index.php/avout/contact/1234

            // 處理路徑型舊式 URL
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $basePath = rtrim(dirname($scriptName), '/');
            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            $path = parse_url($requestUri, PHP_URL_PATH);

            // 去掉專案根目錄
            if (str_starts_with($path, $basePath)) {
                $path = substr($path, strlen($basePath));
            }

            // 如果還有 index.php/ 開頭，把它移除（支援 index.php/about/contact）
            if (str_starts_with($path, 'index.php')) {
                $path = ltrim(substr($path, strlen('index.php')), '/');
            }
            $path = trim($path, '/');
            $segments = $path ? explode('/', $path) : [];
            $controller = $segments[0] ?? 'home';
            $action = $segments[1] ?? 'index';
            $params = array_slice($segments, 2);
        }

        // 處理下底線轉駝峰命名(action 是否包含 '_'?)
        if (preg_match("/_/i", $action)) {
            $myAction = '';
            $segs = explode('_', $action);
            foreach ($segs as $key => $val) {
                $myAction .= $key ? ucfirst($val) : $val;
            }
            $action = $myAction;
        }

        // 將舊式 URL 轉為控制器格式
        $controller = ucfirst(strtolower($controller)); // 確保控制器首字母大寫
        $handler = [$controller, $action];

        // 中介軟體處理（與現代路由一致）
        // 假設舊式路由使用與現代路由相同的預設中介軟體
        $middleware = []; // 可根據需求為舊式路由指定中介軟體
        foreach ($middleware as $middlewareClass) {
            $middleware = new $middlewareClass();
            if (method_exists($middleware, 'handle')) {
                $middleware->handle();
            }
        }

        // 執行控制器
        try {
            require_once PATH_ROOT . "/app/Controllers/{$controller}.php";
            $instance = new $controller();
            foreach ($params as $key => $val) {
                $params[$key] = urldecode($val);
            }
            return call_user_func_array([$instance, $action], $params);
        } catch (\Exception $e) {
            http_response_code(404);
            exit("404 Not Found: " . $e->getMessage());
        }

        http_response_code(404);
        exit("404 Not Found");
    }

    protected function resolveHandler($handler, $params)
    {
        if (is_array($handler)) {
            return $handler;
        }

        // 支援 'Controller::method/$1' 字串格式： 'Controller::method/$1'
        if (preg_match('#^([\w\\\\]+)::([\w]+)(?:/([^/]+))?#', $handler, $matches)) {
            $controller = $matches[1];
            $method = $matches[2];

            // 支援 /$1/$2 替換（可擴充）
            if (isset($matches[3])) {
                foreach ($params as $i => $val) {
                    $method = str_replace('$' . ($i + 1), $val, $method);
                }
            }

            return [$controller, $method];
        }

        throw new \Exception("Invalid handler format.");
    }
}
