<?php

namespace App\Controllers;

class SmartyController
{
    public function index()
    {
        $smarty = service('smarty');

        $time = date('Y-m-d H:i:s');
        $smarty->setTemplateDir(APPPATH.'Views');
        $smarty->setLeftDelimiter("{");
        $smarty->setRightDelimiter("}");
        $smarty->assign('username', 'Laravel');
        $smarty->assign('time', $time);

        return $smarty->display('template.tpl');
    }
}
