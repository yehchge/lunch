<?php

class Router
{
    protected array $routes = [];

    // old router
    protected string $controller;
    protected string $method;
    protected array $params = [];


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

        if (!isset($this->routes[$method])) {
            http_response_code(405);
            exit("405 Method Not Allowed");
        }

        foreach ($this->routes[$method] as $route) {
            $pattern = preg_replace('#\(:segment\)#', '([^/]+)', $route['path']);
            $pattern = '#^/' . trim($pattern, '/') . '$#';

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);

                [$controller, $method] = $this->resolveHandler($route['handler'], $matches);

                // 認證處理
                // if ($route['auth']) {
                //     // session_start();
                //     // if (empty($_SESSION['user'])) {
                //     //     header('Location: /login');
                //     //     exit;
                //     // }
                //     // 檢查使用者有沒有登入
                //     if (!$auth->check()) {
                //         $_SESSION['refer'] = $_SERVER['REQUEST_URI'] ?? '';
                //         header("Location: ".BASE_URL."login");
                //         exit;
                //     }
                // }

                // 中介層處理
                foreach ($route['middleware'] as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    if (method_exists($middleware, 'handle')) {
                        $middleware->handle(); // 可自定義跳轉或 throw
                    }
                }




                require_once PATH_ROOT."/app/Controllers/{$controller}.php";
                $instance = new $controller();

                foreach($matches as $key => $val){
                    $matches[$key] = urldecode($val);
                }

                return call_user_func_array([$instance, $method], $matches);
            }
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

        throw new Exception("Invalid handler format.");
    }

    // old router
    private function old_router()
    {
        // init
        $func = '';
        $action = '';
        $params = [];

        $defaultFunc = 'home';
        $defaultAction = 'index';

        if(!empty($_GET['func']) || !empty($_GET['action'])) {
            // 有舊網址參數 $_GET['func'] or $_GET['action']

            $func = $_GET['func'] ?? '';
            $action = $_GET['action'] ?? '';

            $params = [];
            foreach($_GET as $key => $value) {
                if(!in_array($key, ['func', 'action'])) {
                    $params[] = $value;
                }
            }
        } else {
            // 沒有舊網址參數
            // index.php/about/contact/1234
            // /about/contact/1234
            // /專案名稱/index.php/avout/contact/1234

            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $basePath = rtrim(dirname($scriptName), '/');

            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            $path = parse_url($requestUri, PHP_URL_PATH);

            // 去掉專案根目錄
            if(str_starts_with($path, $basePath)) {
                $path = substr($path, strlen($basePath));
            } else {
                $path = $requestUri;
            }
            $path = trim($path, '/');

            // 如果還有 index.php/ 開頭，把它移除（支援 index.php/about/contact）
            if (str_starts_with($path, 'index.php')) {
                $path = ltrim(substr($path, strlen('index.php')), '/');
            }

            $path = trim($path, '/');
            if ($path) $segments = explode('/', $path);
            else $segments = [];

            $func = $segments[0] ?? '';
            $action = $segments[1] ?? '';
            $params = array_slice($segments, 2);
        }

        // action 是否包含 '_'?
        if(preg_match("/_/i", $action)){
            $myAction = '';

            $segs = explode('_', $action);
            foreach($segs as $key => $val){
                if(!$key) {
                    $myAction .= $val;
                } else {
                    $myAction .= ucfirst($val);
                }
            }
            $action = $myAction;
        }

        $this->controller = $func;
        $this->method = $action;
        $this->params = $params;
    }


    public function func(): string
    {
        $this->old_router();
        return $this->controller;
    }

    public function action(): string
    {
        $this->old_router();
        return $this->method;
    }

    public function params(): array
    {
        $this->old_router();
        return $this->params;
    }



}
