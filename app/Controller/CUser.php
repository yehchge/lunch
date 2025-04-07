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

        $Lnh = new LnhLnhCfactory();

        // 內頁功能 (FORM)
        $tpl = new Template("tpl");

        $tpl->assign('title', '');
        $tpl->assign('breadcrumb', '');
        return $tpl->display('register.htm');
    }

    // 送出註冊表單
    private function create()
    {

    }
}