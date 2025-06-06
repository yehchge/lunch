<?php

/**
 * Config
 */

declare(strict_types=1); // 嚴格類型

defined('PATH_ROOT') || define('PATH_ROOT', realpath(dirname(__FILE__) . '/../..'));
defined('BASE_URL') || define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/');

defined('SYSTEMPATH') || define('SYSTEMPATH', PATH_ROOT . '/System');



require PATH_ROOT."/vendor/autoload.php";

// 自動加載的函式
spl_autoload_register(function ($className) {
    // 定義類檔案所在的目錄
    // $baseDir = PATH_ROOT . '/app/Models/';

    // 定義多個檔案的所在目錄
    $dirs = [
        PATH_ROOT . '/app/System/',
        PATH_ROOT . '/app/Models/',
        PATH_ROOT . '/app/Controllers/'
    ];

    // 將類名轉換為檔案路徑
    // $file = $baseDir . $className . '.php';

    // 將類名轉換為檔案路徑（替換命名空間分隔符）
    $classPath = str_replace('\\', '/', $className) . '.php';


    // 遍歷每個目錄，檢查檔案是否存在
    foreach ($dirs as $baseDir) {
        $file = $baseDir . $classPath;
        if (file_exists($file)) {
            require $file;
            return; // 找到並載入檔案後退出
        }
    }


    // 檢查檔案是否存在，若存在則載入
    // if (file_exists($file)) {
    //     require $file;
    // }
    // // else {
    // //     // 可選：拋出異常或記錄錯誤 開啟會導致 smarty 錯誤
    // //     throw new Exception("Config: Class $className not found in $file");
    // // }
});

require PATH_ROOT.'/app/System/DotEnv.php';

use App\System\DotEnv;
(new DotEnv(PATH_ROOT . '/.env'))->load();

// $dot = new DotEnv(PATH_ROOT . '/.env');
// $dot->load();

// echo getenv('LUNCH_ENV');echo "<br>";
// echo getenv("DATABASE_HOST");exit;

require PATH_ROOT.'/app/Config/App.php';
require PATH_ROOT.'/app/Helpers/utils.php';
require PATH_ROOT.'/app/Helpers/service.php';
require PATH_ROOT.'/app/Helpers/session_helper.php';

require PATH_ROOT.'/app/System/BaseCommand.php';

require PATH_ROOT.'/app/System/Container.php';

// 初始化容器
$container = new Container();

// 綁定 EmployeeModel（可選，容器會自動解析）
// $container->bind(EmployeeModel::class, EmployeeModel::class);

require PATH_ROOT.'/app/System/Core.php';
$core = new Core();


require PATH_ROOT.'/app/System/File.php';

require PATH_ROOT.'/app/System/ViewEngine.php';

require PATH_ROOT.'/app/Config/Paths.php';
require PATH_ROOT.'/app/System/Events.php';

require PATH_ROOT.'/app/Config/Events.php';
Events::trigger('pre_system');

require PATH_ROOT.'/app/System/DebugConsole.php';
require PATH_ROOT.'/app/System/Database.php';
require PATH_ROOT.'/app/Repository/UserRepository.php';
require PATH_ROOT.'/app/Auth/Auth.php';
require PATH_ROOT.'/app/Repository/StoreRepository.php';
require PATH_ROOT.'/app/Repository/ProductRepository.php';
require PATH_ROOT.'/app/Repository/OrderRepository.php';
require PATH_ROOT.'/app/Repository/ManagerRepository.php';


require PATH_ROOT.'/app/System/Model.php';
require PATH_ROOT.'/app/Models/PaginationModel.php';
require PATH_ROOT.'/app/Models/DummyTableModel.php';
require PATH_ROOT.'/app/Models/NewsModel.php';

require PATH_ROOT.'/app/System/JavaScript.php';
require PATH_ROOT.'/app/System/Template.php';
require PATH_ROOT.'/app/System/Paginator.php';
require PATH_ROOT.'/app/System/Pagebar.php';
require PATH_ROOT.'/app/System/CRequest.php';
require PATH_ROOT.'/app/System/CResponse.php';

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
