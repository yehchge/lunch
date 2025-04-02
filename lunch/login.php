<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT.'/app/System/JavaScript.php';

if( ! $_POST){
    //產生本程式功能內容
    // Ref: https://gist.github.com/code-boxx/957284646e7336ae01bb7a5e64f96022

    // require PATH_ROOT."/lunch/gphplib/class.FastTemplate.php"; 
    require PATH_ROOT."/app/System/Template.php"; 

    

    $error = JavaScript::getFlashMessage();
    // $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
    $tpl = new Template("tpl");
    $tpl->assign('error', $error);
    $tpl->display('login.htm');
    // $tpl->define(array('apg6'=>"Login_IF.htm"));
    // $tpl->parse('MAIN',"apg6");
    // $tpl->FastPrint('MAIN');
}












// 以下是 $_POST 才需要
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

        $refer = $_SESSION['refer'] ?? '';
        if($refer){
            $_SESSION['refer'] = '';
            unset($_SESSION['refer']);
            JavaScript::redirect($refer);
        }else{
            header("Location: ./index.php");
        }



        // header("Location: ./index.php");
        // exit;
    } else {
        $error = "帳號或密碼錯誤";
        JavaScript::redirect('./login.php', $error);
    }
}

// $Lnh = new LnhLnhCfactory();

// $UserName = trim($_POST["username"]);
// $Password = trim($_POST["password"]);

// if ($Lnh->LnhLogin($UserName,$Password)) {

//     header("location:./index.php");
//     return;
// } else {

//     header("location:./loginFail.php");
//     return;
// }


