<?php

declare(strict_types=1); // 嚴格類型

defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT.'/app/System/Database.php';
require PATH_ROOT.'/app/Repository/UserRepository.php';
require PATH_ROOT.'/app/Auth/Auth.php';

$db = new Database();
$userRepo = new UserRepository($db);
$auth = new Auth($userRepo);

$auth->logout();
header("Location: ./login.php");
exit;
