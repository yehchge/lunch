<?php

class CLogin
{
    public function handleRequest()
    {
        $action = $_GET['action'] ?? '';
        try{
            switch($action){
                case 'login':
                default:
                    return $this->tLogin();
                    break;
            }
        }catch (\Exception $e){
            echo $e->getMessage().PHP_EOL;
            exit;
        }
    }

    private function tLogin(){

        if( ! $_POST){
            //產生本程式功能內容
            // Ref: https://gist.github.com/code-boxx/957284646e7336ae01bb7a5e64f96022

            $error = JavaScript::getFlashMessage();
          
            $tpl = new Template("app/Views");
            // $tpl->setDebug();
            $tpl->setDelimiters('[[', ']]');

            $tpl->assign('error', $error);
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
                if($refer){
                    $_SESSION['refer'] = '';
                    unset($_SESSION['refer']);
                    JavaScript::redirect($refer);
                }else{
                    header("Location: ./index.php");
                }
            } else {
                $error = "帳號或密碼錯誤";
                JavaScript::redirect('./index.php?func=login', $error);
            }
        }

    }
}