<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
// echo PATH_ROOT;exit;

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();
// $dot = new DotEnv(PATH_ROOT . '/.env');
// $dot->load();


// echo getenv('LUNCH_ENV');

// echo "<br>";

// echo getenv("DATABASE_HOST");
// exit;



include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";
include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";


header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

$Lnh = new LnhLnhCfactory();


try{
    // 檢查使用者有沒有登入
    $Online = $Lnh->GetOnline();

    if(!$Online[0]) {
        header("Location:./Login.php");
        return;
    }

    //產生本程式功能內容
    $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
    $tpl->define(array('apg6'=>"LunchMain.tpl")); 
    $tpl->assign("FUNCTION","");
    $tpl->assign("LOCATION","DinBenDon首頁");
    $tpl->parse('MAIN',"apg6");
    $tpl->FastPrint('MAIN');
}catch (\Exception $e){
    echo $e->getMessage().PHP_EOL;
    exit;
}
