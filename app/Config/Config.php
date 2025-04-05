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

include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";
include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

// header("Cache-Control: no-cache");
// header("Pragma: no-cache");
// header("Expires: Tue, Jan 12 1999 05:00:00 GMT");

require PATH_ROOT.'/app/System/Database.php';
require PATH_ROOT.'/app/Repository/UserRepository.php';
require PATH_ROOT.'/app/Auth/Auth.php';
