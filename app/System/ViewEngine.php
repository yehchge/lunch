<?php

class ViewEngine
{
    protected string $layout = '';
    protected array $sections = [];
    protected string $currentSection = '';
    protected bool $sectionOpen = false;

    public function extend(string $layout)
    {
        $this->layout = $layout;
    }

    public function section(string $name)
    {
        $this->currentSection = $name;
        $this->sectionOpen = true;
        ob_start();
    }

    public function endSection()
    {
        if ($this->sectionOpen) {
            $this->sections[$this->currentSection] = ob_get_clean();
            $this->sectionOpen = false;
            $this->currentSection = '';
        }
    }

    public function renderSection(string $name)
    {
        echo $this->sections[$name] ?? '';
    }

    public function render(string $view, array $data = [])
    {
        // 設定 views 的資料夾路徑
        $viewPath = PATH_ROOT . '/app/Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(404);
            echo "View '{$view}' not found.";
            return;
        }

        // 將 data 陣列的 key 轉成變數
        extract($data);

        $engine = $this;

        // 啟動輸出緩衝
        ob_start();

        // 載入 view 檔案
        include $viewPath;

        // 清掉剛剛的輸出緩衝區（不輸出、不保留）
        ob_end_clean();

        if ($this->layout) {
            $layoutPath = PATH_ROOT . '/app/Views/' . $this->layout . '.php';
            if (file_exists($layoutPath)) {
                // 啟動輸出緩衝
                ob_start();

                // 載入 view 檔案
                include $layoutPath;

                // 取得緩衝內容
                $output = ob_get_clean();

            } else {
                die("Layout '{$this->layout}' not found.");
            }
        } else {
            // 啟動輸出緩衝
            ob_start();

            // 沒有 layout，就直接輸出
            include $viewPath;

            // 取得緩衝內容
            $output = ob_get_clean();
        }

        $elapsed_time = number_format(microtime(true) - CI_START, 4);

        echo str_replace(
            ['{elapsed_time}', '{memory_usage}'],
            [(string) $elapsed_time, number_format(memory_get_peak_usage() / 1024 / 1024, 3)],
            $output,
        );

    }
}

function view(string $view, array $data = [])
{
    static $engine = null;

    if ($engine === null) {
        $engine = new ViewEngine();
    }

    $engine->render($view, $data);
}

function esc(string $string)
{
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
}
