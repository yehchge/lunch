<?php

// 登入
namespace App\Controllers;

use App\System\JavaScript;
use App\System\Template;
use App\System\Database;
use App\Repository\UserRepository;
use App\Auth\Auth;

class CLogin
{
    public function index()
    {

        if(! $_POST) {
            //產生本程式功能內容
            // Ref: https://gist.github.com/code-boxx/957284646e7336ae01bb7a5e64f96022

            $error = JavaScript::getFlashMessage();
          
            $tpl = new Template("app/Views");
            // $tpl->setDebug();
            $tpl->setDelimiters('<{', '}>');

            $tpl->assign('error', $error);
            $tpl->assign('baseUrl', BASE_URL);
            $tpl->assign('csrf', csrf_field());
            $tpl->display('login.htm');
            exit;
        }

        // 以下是 $_POST 才需要
        $db = new Database();
        $userRepo = new UserRepository($db);
        $auth = new Auth($userRepo);

        // 產生密碼
        // $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        // echo 'password = ' . $password . PHP_EOL;exit;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $rememberMe = isset($_POST['remember_me']);

            if ($auth->login($username, $password, $rememberMe)) {

                $refer = $_SESSION['refer'] ?? '';
                if($refer) {
                    $_SESSION['refer'] = '';
                    unset($_SESSION['refer']);
                    JavaScript::redirectTo($refer);
                }else{
                    header("Location: ".BASE_URL);
                }
            } else {
                JavaScript::redirectTo(BASE_URL.'login', "帳號或密碼錯誤");
            }
        }
    }
}
