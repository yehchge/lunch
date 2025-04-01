<?php

class CUser
{
    public function tManager()
    {
        $action = $_GET['action'] ?? '';

        switch($action){
            case 'register':
                return $this->register();
                break;
            case 'list': // user list
            default:
                return $this->index();
                break;
        }
    }

    // 顯示註冊
    private function register()
    {
        if ($_POST) {
            return $this->create();
        }

        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";

        $Lnh = new LnhLnhCfactory();

        // 產生本程式功能內容
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('apg6'=>"register.htm")); 
        $tpl->parse('BODY',"apg6");
        return $str = $tpl->fetch('BODY');

    }

    // 送出註冊表單
    private function create()
    {

    }
}