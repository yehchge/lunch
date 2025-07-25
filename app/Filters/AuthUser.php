<?php

namespace App\Filters;

class AuthUser
{
    public function handle()
    {
        $auth = service('auth');

        // 檢查使用者有沒有登入
        if (!$auth->check()) {
            $_SESSION['refer'] = $_SERVER['REQUEST_URI'] ?? '';
            header("Location: ".BASE_URL."login");
            exit;
        }
    }
}
