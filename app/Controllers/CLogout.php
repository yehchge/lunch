<?php

// 登出
namespace App\Controllers;

use App\System\Database;
use App\Repository\UserRepository;
use App\Auth\Auth;

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
