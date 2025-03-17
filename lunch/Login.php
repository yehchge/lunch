<?php

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";	


header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

//產生本程式功能內容

try{


	$tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");


	$tpl->define(array('apg6'=>"Login.tpl")); 


	$tpl->parse('MAIN',"apg6");

	$tpl->FastPrint('MAIN');


}catch(Exception $e){
	echo $e->getMessage();exit;
}
