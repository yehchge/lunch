<?php

declare(strict_types=1); // 嚴格類型

require '../app/Config/Config.php';

$db = new Database();
$userRepo = new UserRepository($db);
$auth = new Auth($userRepo);

$auth->logout();
header("Location: ./login.php");
exit;
