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

    // 啟動輸出緩衝
    ob_start();

    // 載入 view 檔案
    include $viewPath;

    // 取得緩衝內容
    $output = ob_get_clean();

    $elapsed_time = number_format(microtime(true) - CI_START, 4);

    echo str_replace(
        ['{elapsed_time}', '{memory_usage}'],
        [(string) $elapsed_time, number_format(memory_get_peak_usage() / 1024 / 1024, 3)],
        $output,
    );
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
