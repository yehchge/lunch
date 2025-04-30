<?php

function view(string $viewName, array $data = []): void
{
    // 設定 views 的資料夾路徑
    $viewPath = PATH_ROOT . '/app/Views/' . $viewName . '.php';

    if (!file_exists($viewPath)) {
        http_response_code(404);
        echo "View '{$viewName}' not found.";
        return;
    }

    // 將 data 陣列的 key 轉成變數
    extract($data);

    // 載入 view 檔案
    include $viewPath;
}


class Home 
{
    public function index()
    {
        view('welcome_message');
    }
}