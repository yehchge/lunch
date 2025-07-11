<?php

/**
 * PHP 路由解析器（Router），用於處理兩種不同格式的網址（舊式 GET 參數和現代 URL 路徑）
 * ，並從中提取三個主要部分：功能名稱（func）、動作名稱（action）和參數（params）。
 * 這些資訊可用於網頁應用程式中的路由分派，例如決定要執行哪個控制器或方法，
 * 或者在資料分頁時根據 func 和 action 來處理請求。
 */

declare(strict_types=1);

namespace App\System;

class UrlParse
{
    private const DEFAULT_FUNC = 'home'; // 預設功能名稱
    private const DEFAULT_ACTION = 'index'; // 預設動作名稱
    private const RESERVED_PARAMS = ['func', 'action']; // 保留的參數名稱
    private const VALID_PARAM_PATTERN = '/^[a-zA-Z0-9_]+$/'; // 參數格式正則表達式

    /**
     * 取得路由中的功能名稱
     *
     * @return string 功能名稱
     * @throws RouterException 如果功能名稱無效
     */
    public function getFunction(): string
    {
        return $this->parseRoute()['func'];
    }

    /**
     * 取得路由中的動作名稱
     *
     * @return string 動作名稱
     * @throws RouterException 如果動作名稱無效
     */
    public function getAction(): string
    {
        return $this->parseRoute()['action'];
    }

    /**
     * 取得路由中的參數
     *
     * @return array 路由參數
     * @throws RouterException 如果參數無效
     */
    public function getParams(): array
    {
        return $this->parseRoute()['params'];
    }

    /**
     * 解析路由，支援舊式 GET 參數或現代 URL 路徑
     *
     * @return array{func: string, action: string, params: array} 路由組成部分
     * @throws RouterException 如果路由解析失敗
     */
    private function parseRoute(): array
    {
        try {
            // 檢查是否有舊式參數
            if ($this->hasLegacyParams()) {
                return $this->parseLegacyRoute();
            }

            // 處理現代 URL 路由
            return $this->parseModernRoute();
        } catch (Exception $e) {
            $this->logError('路由解析失敗: ' . $e->getMessage());
            throw new RouterException('無法解析路由: ' . $e->getMessage(), 0, $e);
        }

    }

    /**
     * 檢查是否有舊式 GET 參數
     *
     * @return bool 如果有 func 或 action 參數則返回 true
     */
    private function hasLegacyParams(): bool
    {
        return !empty($_GET['func']) || !empty($_GET['action']);
    }

    /**
     * 解析舊式 GET 參數路由
     *
     * @return array{func: string, action: string, params: array}
     * @throws RouterException 如果參數無效
     */
    private function parseLegacyRoute(): array
    {
        // 初始化預設值
        // $route = [
        //     'func' => self::DEFAULT_FUNC,
        //     'action' => self::DEFAULT_ACTION,
        //     'params' => []
        // ];

        $func = $_GET['func'] ?? self::DEFAULT_FUNC;
        $action = $_GET['action'] ?? self::DEFAULT_ACTION;
        $params = [];

        // 驗證 func 和 action 格式
        $this->validateParam($func, '功能名稱');
        $this->validateParam($action, '動作名稱');

        // 收集其他參數
        foreach ($_GET as $key => $value) {
            if (!in_array($key, self::RESERVED_PARAMS, true)) {
                if ($this->isValidParam($value)) {
                    $params[] = $value;
                } else {
                    $this->logError("無效的 GET 參數: $key=$value");
                }
            }
        }

        return [
            'func' => $func,
            'action' => $action,
            'params' => $params
        ];
    }

    /**
     * 解析現代 URL 路徑路由
     *
     * @return array{func: string, action: string, params: array}
     * @throws RouterException 如果路徑無效
     */
    private function parseModernRoute(): array
    {
        $path = $this->getCleanPath();
        $segments = $this->getPathSegments($path);

        // 驗證路徑
        if (empty($segments) && $path !== '') {
            $this->logError("無效的路徑: $path");
            throw new RouterException('無效的 URL 路徑');
        }

        $func = $segments[0] ?? self::DEFAULT_FUNC;
        $action = $segments[1] ?? self::DEFAULT_ACTION;
        $params = array_slice($segments, 2);

        // 驗證 func 和 action
        $this->validateParam($func, '功能名稱');
        $this->validateParam($action, '動作名稱');

        // 驗證並清理參數
        $validParams = [];
        foreach ($params as $param) {
            if ($this->isValidParam($param)) {
                $validParams[] = $param;
            } else {
                $this->logError("無效的路徑參數: $param");
            }
        }

        return [
            'func' => $func,
            'action' => $action,
            'params' => $validParams
        ];
    }

    /**
     * 取得清理後的 URL 路徑（移除基底路徑和 index.php）
     *
     * @return string 清理後的路徑
     * @throws RouterException 如果無法取得路徑
     */
    private function getCleanPath(): string
    {
        try {
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            $basePath = rtrim(dirname($scriptName), '/');
            $requestUri = $_SERVER['REQUEST_URI'] ?? '';

            // 解析請求 URI 的路徑部分
            $path = parse_url($requestUri, PHP_URL_PATH) ?? '';
            if ($path === '') {
                $this->logError('無法取得請求 URI');
                throw new RouterException('無法取得請求路徑');
            }

            // 移除基底路徑
            if ($basePath && str_starts_with($path, $basePath)) {
                $path = substr($path, strlen($basePath));
            }

            // 移除 index.php（如果存在）
            if (str_starts_with($path, '/index.php')) {
                $path = substr($path, strlen('/index.php'));
            }

            return trim($path, '/');
        } catch (Exception $e) {
            $this->logError('路徑清理失敗: ' . $e->getMessage());
            throw new RouterException('路徑處理錯誤: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * 將路徑分割成片段
     *
     * @param  string $path URL 路徑
     * @return array 路徑片段
     */
    private function getPathSegments(string $path): array
    {
        return $path ? explode('/', $path) : [];
    }

    /**
     * 驗證參數格式
     *
     * @param  string $param     參數值
     * @param  string $paramName 參數名稱（用於錯誤訊息）
     * @throws RouterException 如果參數無效
     */
    private function validateParam(string $param, string $paramName): void
    {
        if ($param !== '' && !$this->isValidParam($param)) {
            $this->logError("無效的{$paramName}: $param");
            throw new RouterException("無效的{$paramName}: $param");
        }
    }

    /**
     * 檢查參數是否有效
     *
     * @param  string $param 參數值
     * @return bool 是否有效
     */
    private function isValidParam(string $param): bool
    {
        return preg_match(self::VALID_PARAM_PATTERN, $param) === 1;
    }

    /**
     * 記錄錯誤訊息
     *
     * @param string $message 錯誤訊息
     */
    private function logError(string $message): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $requestUri = $_SERVER['REQUEST_URI'] ?? '未知';
        error_log("[$timestamp] 路由錯誤: $message (請求: $requestUri)");
    }
}
