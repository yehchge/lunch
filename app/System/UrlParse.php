<?php

/**
 * PHP 路由解析器（Router），用於處理兩種不同格式的網址（舊式 GET 參數和現代 URL 路徑）
 * ，並從中提取三個主要部分：功能名稱（func）、動作名稱（action）和參數（params）。
 * 這些資訊可用於網頁應用程式中的路由分派，例如決定要執行哪個控制器或方法，
 * 或者在資料分頁時根據 func 和 action 來處理請求。
 */

declare(strict_types=1);

class UrlParse
{
    private const DEFAULT_FUNC = 'home';
    private const DEFAULT_ACTION = 'index';
    private const RESERVED_PARAMS = ['func', 'action'];

    /**
     * Get the function name from the route
     * @return string The function name
     */
    public function getFunction(): string
    {
        return $this->parseRoute()['func'];
    }

    /**
     * Get the action name from the route
     * @return string The action name
     */
    public function getAction(): string
    {
        return $this->parseRoute()['action'];
    }

    /**
     * Get the parameters from the route
     * @return array The route parameters
     */
    public function getParams(): array
    {
        return $this->parseRoute()['params'];
    }

    /**
     * Parse the route from either GET parameters or URL path
     * @return array{func: string, action: string, params: array} Route components
     */
    private function parseRoute(): array
    {
        // Initialize default values
        $route = [
            'func' => self::DEFAULT_FUNC,
            'action' => self::DEFAULT_ACTION,
            'params' => []
        ];

        // Handle legacy URL parameters (func/action in query string)
        if ($this->hasLegacyParams()) {
            return $this->parseLegacyRoute();
        }

        // Handle modern URL routing
        return $this->parseModernRoute();
    }

    /**
     * Check if legacy GET parameters exist
     * @return bool True if func or action parameters are present
     */
    private function hasLegacyParams(): bool
    {
        return !empty($_GET['func']) || !empty($_GET['action']);
    }

    /**
     * Parse route from legacy GET parameters
     * @return array{func: string, action: string, params: array}
     */
    private function parseLegacyRoute(): array
    {
        $params = [];
        foreach ($_GET as $key => $value) {
            if (!in_array($key, self::RESERVED_PARAMS, true)) {
                $params[] = $value;
            }
        }

        return [
            'func' => $_GET['func'] ?? self::DEFAULT_FUNC,
            'action' => $_GET['action'] ?? self::DEFAULT_ACTION,
            'params' => $params
        ];
    }

    /**
     * Parse route from modern URL path
     * @return array{func: string, action: string, params: array}
     */
    private function parseModernRoute(): array
    {
        $path = $this->getCleanPath();
        $segments = $this->getPathSegments($path);

        return [
            'func' => $segments[0] ?? self::DEFAULT_FUNC,
            'action' => $segments[1] ?? self::DEFAULT_ACTION,
            'params' => array_slice($segments, 2)
        ];
    }

    /**
     * Get cleaned URL path without base path and index.php
     * @return string Cleaned path
     */
    private function getCleanPath(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = rtrim(dirname($scriptName), '/');
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';

        // Parse path from request URI
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '';

        // Remove base path
        if ($basePath && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }

        // Remove index.php if present
        if (str_starts_with($path, '/index.php')) {
            $path = substr($path, strlen('/index.php'));
        }

        return trim($path, '/');
    }

    /**
     * Split path into segments
     * @param string $path The URL path
     * @return array Path segments
     */
    private function getPathSegments(string $path): array
    {
        return $path ? explode('/', $path) : [];
    }
}
