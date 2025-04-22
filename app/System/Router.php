<?php

class Router
{
    protected string $controller;
    protected string $method;
    protected array $params = [];

    public function __construct()
    {
        // init
        $func = '';
        $action = '';
        $params = [];

        $defaultFunc = '';
        $defaultAction = 'index';

        if(!empty($_GET['func']) || !empty($_GET['action'])) {
            // 有舊網址參數 $_GET['func'] or $_GET['action']
            
            $func = $_GET['func'] ?? '';
            $action = $_GET['action'] ?? $defaultAction;

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
            $segments = explode('/', $path);
            $func = $segments[0] ?? '';
            $action = $segments[1] ?? $defaultAction;
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
        return $this->controller;
    }

    public function action(): string
    {
        return $this->method;
    }

    public function params(): array
    {
        return $this->params;
    }
}