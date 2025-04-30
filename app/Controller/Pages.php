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

function esc(string $string)
{
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
}

class Pages
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view(string $page = 'home')
    {
        $controllerFile = PATH_ROOT."/app/Views/pages/{$page}.php";
        if (!file_exists($controllerFile)){
            // Whoops, we don't have a page for that!
            // throw new PageNotFoundException($page);
            http_response_code(404);
            echo "404 Not Found - $page";
            exit;
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }

}