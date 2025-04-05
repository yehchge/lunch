<?php

$routes = [
	'store' => 'CStore',
	'product' => 'CProduct',
	'manager' => 'CManager',
	'order' => 'COrder',
];

$func = $_GET['func'] ?? '';
$action = $_GET['action'] ?? '';

$sController = $routes[$func] ?? '';

if($sController!==''){
    //include, new target controller, and run tManager
    include_once(PATH_ROOT."/app/Controller/$sController.php"); //include controller.php
    $oController = new $sController();  //new target controller
    $tpl->assign("FUNCTION", $oController->tManager());   //call controller entry function
} else {
    $tpl->assign("FUNCTION", '');
}
