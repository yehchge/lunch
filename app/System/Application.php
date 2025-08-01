<?php

// 檔案：src/Core/Application.php
// 框架核心應用類

namespace App\System;

use App\Security\CsrfFilter;
use App\System\FilterManager;
use App\System\SecurityException;

class Application
{
    protected $filterManager;

    public function __construct()
    {
        $this->filterManager = new FilterManager();
        $this->configureFilters();

        // Register shutdown function to clear flash data
        register_shutdown_function(function () {
            if (function_exists('session')) {
                session()->clearFlashdata();
            }
        });
    }

    protected function configureFilters()
    {
        // 配置 CSRF 過濾器，應用於特定路由
        // $this->filterManager->register('before', CsrfFilter::class, ['/form/*']);
        // 全局應用 CSRF 過濾器
        $this->filterManager->register('before', CsrfFilter::class, [], ['employee/*', 'employee', 'api/register']);
    }

    public function handleRequest()
    {
        $request = new CRequest();
        $response = new CResponse();

        try {
            // 執行 Before 過濾器
            $this->filterManager->runBeforeFilters($request, $response);

            $routes = include PATH_ROOT."/app/Config/Routes.php";
            // \Redirect::$routes = $routes->getRoutes();

            $routes->dispatch();

            // 執行 After 過濾器
            $this->filterManager->runAfterFilters($request, $response);
        } catch (SecurityException $e) {
            // 根據請求類型處理錯誤
            $this->handleError($request, $response, $e);
        } catch (\Exception $e) {
            $this->handleError($request, $response, $e);
        }
    }

    protected function handleError(CRequest $request, CResponse $response, \Exception $e)
    {
        // 清除之前的輸出緩衝區，防止其他內容干擾
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        // 檢查是否為 AJAX 請求
        $isAjax = $request->isAjax();

        if ($isAjax) {
            // 返回 JSON 錯誤訊息
            $response->setHeader('Content-Type', 'application/json');
            $response->json(
                [
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
                ], 403
            );
        } else {
            // 返回 HTML 錯誤頁面
            $response->setHeader('Content-Type', 'text/html; charset=UTF-8', true)
                ->setTerminate()
                ->send($this->renderErrorPage($e->getMessage(), (int)$e->getCode()));
        }
        // exit; // 確保終止後續處理
    }

    protected function renderErrorPage(string $message, int $code): string
    {
        // 簡單的錯誤頁面樣板
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Error <?php echo $code; ?></title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                h1 { color: #d9534f; }
                p { font-size: 18px; }
            </style>
        </head>
        <body>
            <h1>Error <?php echo $code; ?></h1>
            <p><?php echo htmlspecialchars($message); ?></p>
            <a href="<?php echo base_url(); ?>">Back to Home</a>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }

}
