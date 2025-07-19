<?php

// 檔案：src/Security/CsrfFilter.php
// CSRF 過濾器實現

namespace App\Security;

use App\System\FilterInterface;
// use App\Config\Security;
use App\System\CRequest;
use App\System\CResponse;
use App\System\SecurityException;

class CsrfFilter implements FilterInterface
{
    protected $config;

    public function __construct()
    {
        $myConfig = include PATH_ROOT.'/app/Config/Security.php';
        if (isset($myConfig['csrf'])) {
            $this->config = $myConfig['csrf'];
        } else {
            $this->config = [
                'token_name' => 'csrf_token',
                'expire' => 7200, // 2 小時
                'methods' => ['POST', 'PUT', 'DELETE'] // 檢查的 HTTP 方法
            ];
        }
    }

    public function before(CRequest $request, CResponse $response)
    {
        // 只對指定的 HTTP 方法進行檢查
        if (in_array($request->getMethod(), $this->config['methods'])) {
            $this->validateCsrfToken($request, $response);
        }
    }

    public function after(CRequest $request, CResponse $response)
    {
        // 可選：在回應中加入新的 CSRF token
        $this->generateCsrfToken($request);
    }

    public function getTokenName()
    {
        return $this->config['token_name'];
    }

    // 生成 CSRF token
    public function generateCsrfToken(CRequest $request)
    {
        $session = $request->getSession();
        $token = bin2hex(random_bytes(32)); // 生成隨機 token
        $session->set(
            $this->config['token_name'], [
                'value' => $token,
                'expires_at' => time() + $this->config['expire']
            ]
        );
        return $token;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function validateCsrfToken(CRequest $request, CResponse $response)
    {
        $session = $request->getSession();
        $sessionToken = $session->get($this->config['token_name']);
        $requestToken = $request->getPost($this->config['token_name']) ??
                        $request->getHeader('X-CSRF-TOKEN');

        // 檢查 token 是否存在、有效且未過期
        if (!$sessionToken || !$requestToken || $sessionToken['value'] !== $requestToken 
            || time() > $sessionToken['expires_at']
        ) {
            throw new SecurityException('Invalid or missing CSRF token');
        }

        // 驗證通過後可選擇重置 token
        $this->generateCsrfToken($request);
    }
}
