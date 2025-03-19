<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));


require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();


include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";

header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

$Lnh = new LnhLnhCfactory();

//檢測是否有權限? ****************
$Online = $Lnh->GetOnline();
if(!$Online[0]) {
	header("Location:./Login.php");
	return;
}
// *******************************

//setcookie("LunchWhoIs","",0,"/",".taipei.gov.tw");
setcookie("LunchWhoIs","",0,"/","");
header("Location:./Login.php");
