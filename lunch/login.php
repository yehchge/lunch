<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

// require PATH_ROOT."/lunch/gphplib/class.FastTemplate.php"; 
require PATH_ROOT."/app/System/Template.php"; 

//產生本程式功能內容

try{
    $error = '';
    // $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
    $tpl = new Template("tpl");
    $tpl->assign('error', $error);
    $tpl->display('login.htm');
    // $tpl->define(array('apg6'=>"Login_IF.htm"));
    // $tpl->parse('MAIN',"apg6");
    // $tpl->FastPrint('MAIN');
}catch(Exception $e){
    echo $e->getMessage();exit;
}
