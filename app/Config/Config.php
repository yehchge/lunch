<?php

/**
 * Config
 */

declare(strict_types=1); // 嚴格類型

defined('PATH_ROOT') || define('PATH_ROOT', realpath(dirname(__FILE__) . '/../..'));
defined('BASE_URL') || define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/');
defined('SYSTEMPATH') || define('SYSTEMPATH', PATH_ROOT . '/System');

require PATH_ROOT."/vendor/autoload.php";

use App\System\DotEnv;
use App\System\Container;
use App\System\Core;
use App\System\Events;
use App\Config\Paths;

(new DotEnv(PATH_ROOT . '/.env'))->load();

// 初始化容器
$container = new Container();

$core = new Core();

Events::trigger('pre_system');

require PATH_ROOT.'/app/System/ViewEngine.php';
require PATH_ROOT.'/app/Helpers/utils.php';
require PATH_ROOT.'/app/Helpers/service.php';

$Paths = new Paths();
$Paths->definePathConstants();
