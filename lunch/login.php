<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();


require PATH_ROOT."/lunch/gphplib/class.FastTemplate.php"; 
require PATH_ROOT.'/app/System/Database.php';
require PATH_ROOT.'/app/Repository/UserRepository.php';
require PATH_ROOT.'/app/Auth/Auth.php';

$db = new Database();
$userRepo = new UserRepository($db);
$auth = new Auth($userRepo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember_me']);

    if ($auth->login($email, $password, $rememberMe)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "帳號或密碼錯誤";
    }
}
//產生本程式功能內容

try{
    $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
    $tpl->define(array('apg6'=>"Login.htm")); 
    $tpl->parse('MAIN',"apg6");
    $tpl->FastPrint('MAIN');
}catch(Exception $e){
    echo $e->getMessage();exit;
}
