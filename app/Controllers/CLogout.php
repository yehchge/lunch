<?php

# 登出
namespace App\Controllers;

class CLogout
{
    public function index()
    {
        $db = new Database();
        $userRepo = new UserRepository($db);
        $auth = new Auth($userRepo);

        $auth->logout();
        header("Location: ".BASE_URL."login");
    }
}