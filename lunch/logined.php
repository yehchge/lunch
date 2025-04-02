<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();

require PATH_ROOT.'/app/System/Database.php';
require PATH_ROOT.'/app/Repository/UserRepository.php';
require PATH_ROOT.'/app/Auth/Auth.php';

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
        header("Location: ./index.php");
        exit;
    } else {
        $error = "帳號或密碼錯誤";
        exit;
    }
}

$Lnh = new LnhLnhCfactory();

$UserName = trim($_POST["username"]);
$Password = trim($_POST["password"]);

//TODO:暫時
// $UserName = 'admin';
// $Password = 'admin';

if ($Lnh->LnhLogin($UserName,$Password)) {

    header("location:./index.php");
    return;
} else {

    header("location:./loginFail.php");
    return;
}
