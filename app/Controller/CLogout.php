<?php

class CLogout
{
    public function handleRequest()
    {
        $action = $_GET['action'] ?? '';
        try{
            switch($action){
                case 'logout':
                default:
                    return $this->tLogout();
                    break;
            }
        }catch (\Exception $e){
            echo $e->getMessage().PHP_EOL;
            exit;
        }
    }

    private function tLogout()
    {
        $db = new Database();
        $userRepo = new UserRepository($db);
        $auth = new Auth($userRepo);

        $auth->logout();
        header("Location: ./index.php?func=login");
    }
}