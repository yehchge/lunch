<?php

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));
include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";


header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

$Lnh = new LnhLnhCfactory();


$UserName = trim($_POST["username"]);
$Password = trim($_POST["password"]);

//TODO:暫時
$UserName = 'admin';
$Password = 'admin';


if ($Lnh->LnhLogin($UserName,$Password)) {

	header("location:./index.php");
	return;
} else {

	header("location:./LoginFail.php");
	return;
}
