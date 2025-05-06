<?php

function view(string $viewName, array $data = [])
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

function esc(string $string)
{
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
}

function service(string $name)
{
    if (!class_exists('Services')) {
        require_once PATH_ROOT.'/app/Config/Services.php';
    }

    if(method_exists('Services', $name)) {
        return Services::$name();
    }

    throw new Exception("Service '$name' not found.");
}
