<?php

/**
 * Config
 */

declare(strict_types=1); // 嚴格類型

defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/../..'));

require PATH_ROOT."/vendor/autoload.php";
use Lunch\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();

// $dot = new DotEnv(PATH_ROOT . '/.env');
// $dot->load();

// echo getenv('LUNCH_ENV');echo "<br>";
// echo getenv("DATABASE_HOST");exit;

include_once PATH_ROOT."/gphplib/DebugConsole.php";

require PATH_ROOT.'/app/System/Database.php';
require PATH_ROOT.'/app/Repository/UserRepository.php';
require PATH_ROOT.'/app/Auth/Auth.php';
require PATH_ROOT.'/app/Repository/StoreRepository.php';
require PATH_ROOT.'/app/Repository/ProductRepository.php';
require PATH_ROOT.'/app/Repository/OrderRepository.php';
require PATH_ROOT.'/app/Repository/ManagerRepository.php';
require PATH_ROOT.'/app/System/JavaScript.php';
require PATH_ROOT.'/app/System/Template.php';

function dd($data)
{
    echo "<pre>";print_r($data);echo "</pre>";
}