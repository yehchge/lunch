<?php

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();

include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

//產生本程式功能內容
$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
$tpl->define(array('apg6'=>"LoginFail.htm")); 
$tpl->parse('MAIN',"apg6");
$tpl->FastPrint('MAIN');
