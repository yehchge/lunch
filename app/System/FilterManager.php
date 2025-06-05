<?php

// 檔案：src/Core/FilterManager.php
// 過濾器管理器，負責執行過濾器

class FilterManager {
    protected $filters = [
        'before' => [],
        'after' => []
    ];

    // 註冊過濾器
    public function register(string $type, string $filterClass, array $routes = [], array $except = []) {
        // echo "except = ".print_r($except)."<br>";
        $this->filters[$type][] = [
            'class' => $filterClass,
            'routes' => $routes, // 空陣列表示應用於所有路由
            'except' => $except // 排除過濾器的路由
        ];
    }

    // 執行 Before 過濾器
    public function runBeforeFilters(CRequest $request, CResponse $response) {
        foreach ($this->filters['before'] as $filter) {
            if ($this->shouldApply($filter['routes'], $filter['except'], $request->getPath())) {
                // echo "asdfasdfasdf";exit;
                $instance = new $filter['class']();
                $instance->before($request, $response);
            }
        }
    }

    // 執行 After 過濾器
    public function runAfterFilters(CRequest $request, CResponse $response) {
        foreach ($this->filters['after'] as $filter) {
            if ($this->shouldApply($filter['routes'], $filter['except'], $request->getPath())) {
                $instance = new $filter['class']();
                $instance->after($request, $response);
            }
        }
    }

    // 檢查過濾器是否適用於當前路由
    protected function shouldApply(array $routes, array $except, string $path): bool {
        // 檢查是否在 except 列表中
        foreach ($except as $exceptRoute) {
            if (fnmatch('*/'.$exceptRoute, $path)) {
                return false; // 匹配到排除路由，不應用過濾器
            }
        }

        if (empty($routes)) {
            return true; // 空表示全局應用
        }

        // 檢查是否匹配 routes
        foreach ($routes as $route) {
            if (fnmatch($route, $path)) {
                return true;
            }
        }
        return false;
    }
}
