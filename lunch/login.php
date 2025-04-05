<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');

require '../app/Config/Config.php';

require PATH_ROOT.'/app/System/JavaScript.php';

if( ! $_POST){
    //產生本程式功能內容
    // Ref: https://gist.github.com/code-boxx/957284646e7336ae01bb7a5e64f96022

    require PATH_ROOT."/app/System/Template.php";

    $error = JavaScript::getFlashMessage();
  
    $tpl = new Template("tpl");
    // $tpl->setDebug();
    $tpl->setDelimiters('[[', ']]');

    $tpl->assign('error', $error);
    $tpl->display('login.htm');
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
        if($refer){
            $_SESSION['refer'] = '';
            unset($_SESSION['refer']);
            JavaScript::redirect($refer);
        }else{
            header("Location: ./index.php");
        }
    } else {
        $error = "帳號或密碼錯誤";
        JavaScript::redirect('./login.php', $error);
    }
}
