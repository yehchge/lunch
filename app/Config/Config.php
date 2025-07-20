<?php

/**
 * Config
 */

declare(strict_types=1); // 嚴格類型

defined('PATH_ROOT') || define('PATH_ROOT', realpath(dirname(__FILE__) . '/../..'));
defined('BASE_URL') || define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/');
defined('SYSTEMPATH') || define('SYSTEMPATH', PATH_ROOT . '/System');

/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
|
*/
define('HASH_KEY', 'fisherman_pants');


// The sitewide hashkey, do not change this because its used for passwords!
// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', 'MixitUp200');

// This is for database passwords only
define('HASH_PASSWORD_KEY', 'catsFLYhigh2000miles');

require PATH_ROOT."/vendor/autoload.php";
require PATH_ROOT.'/app/System/DotEnv.php';

use App\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();

// $dot = new DotEnv(PATH_ROOT . '/.env');
// $dot->load();

// echo getenv('APP_ENV');echo "<br>";
// echo getenv("DATABASE_HOST");exit;

require PATH_ROOT.'/app/Config/App.php';
require PATH_ROOT.'/app/Helpers/utils.php';
require PATH_ROOT.'/app/Helpers/service.php';
require PATH_ROOT.'/app/System/Redirect.php';

require PATH_ROOT.'/app/System/BaseCommand.php';

use App\System\Container;
// require PATH_ROOT.'/app/System/Container.php';

// 初始化容器
$container = new Container();

// 綁定 EmployeeModel（可選，容器會自動解析）
// $container->bind(EmployeeModel::class, EmployeeModel::class);

// require PATH_ROOT.'/app/System/Core.php';

use App\System\Core;

$core = new Core();

require PATH_ROOT.'/app/System/File.php';

require PATH_ROOT.'/app/System/ViewEngine.php';

// require PATH_ROOT.'/app/Config/Paths.php';

// 事件 Events
require PATH_ROOT.'/app/Config/Events.php';
// require PATH_ROOT.'/app/System/Events.php';

use App\System\Events;
// use App\Config\Events;

Events::trigger('pre_system');

require PATH_ROOT.'/app/Repository/UserRepository.php';
require PATH_ROOT.'/app/Auth/Auth.php';
require PATH_ROOT.'/app/Repository/StoreRepository.php';
require PATH_ROOT.'/app/Repository/ProductRepository.php';
require PATH_ROOT.'/app/Repository/OrderRepository.php';
require PATH_ROOT.'/app/Repository/ManagerRepository.php';

use App\Config\Paths;

$Paths = new Paths();
definePathConstants($Paths);

function dd($data)
{
    echo "<pre>";print_r($data);echo "</pre>";
}

function class_basename($class)
{
    $class = is_object($class) ? $class::class : $class;

    return basename(str_replace('\\', '/', $class));
}


function definePathConstants(Paths $paths): void
{
    // The path to the application directory.
    if (! defined('APPPATH')) {
        define('APPPATH', realpath(rtrim($paths->appDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
    }

    // The path to the project root directory. Just above APPPATH.
    if (! defined('ROOTPATH')) {
        define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
    }

    // The path to the writable directory.
    if (! defined('WRITEPATH')) {
        $writePath = realpath(rtrim($paths->writableDirectory, '\\/ '));

        if ($writePath === false) {
            header('HTTP/1.1 503 Service Unavailable.', true, 503);
            echo 'The WRITEPATH is not set correctly.';

            // EXIT_ERROR is not yet defined
            exit(1);
        }
        define('WRITEPATH', $writePath . DIRECTORY_SEPARATOR);
    }
}
