<?php

namespace App\Controllers;

class CUser
{
    public function index(){}

    // 顯示註冊
    public function register()
    {
        if ($_POST) {
            return $this->create();
        }

        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $tpl->assign('title', '');
        $tpl->assign('breadcrumb', '');
        $tpl->assign('baseUrl', BASE_URL);
        return $tpl->display('register.htm');
    }

    // 送出註冊表單
    private function create(){}
}
