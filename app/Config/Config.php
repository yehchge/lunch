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
    // 定義多個檔案的所在目錄
    $dirs = [
        PATH_ROOT . '/app/System/',
        PATH_ROOT . '/app/Models/',
        PATH_ROOT . '/app/Config/',
        PATH_ROOT . '/app/Controllers/'
    ];

    // 將類名轉換為檔案路徑（替換命名空間分隔符）
    $classPath = str_replace('\\', '/', $className) . '.php';

    // 遍歷每個目錄，檢查檔案是否存在
    foreach ($dirs as $baseDir) {
        $file = $baseDir . $classPath;
        if (file_exists($file)) {
            require $file;
            return; // 找到並載入檔案後退出
        } else {
            // 可選：如果檔案未找到，記錄錯誤或拋出異常
            // 避免直接拋出異常以防止 Smarty 或其他第三方庫的問題
            error_log("Class $className not found in any defined directories.");
        }
    }
});


// /* 進階：使用 PSR-4 標準自動加載 */
// spl_autoload_register(function ($className) {
//     // 定義命名空間與目錄的映射
//     $prefixes = [
//         'App\\Models\\' => PATH_ROOT . '/app/Models/',
//         'App\\Controllers\\' => PATH_ROOT . '/app/Controllers/',
//         'App\\Services\\' => PATH_ROOT . '/app/Services/',
//         'App\\Libraries\\' => PATH_ROOT . '/app/Libraries/',
//     ];

//     foreach ($prefixes as $prefix => $baseDir) {
//         // 檢查類名是否以該命名空間開頭
//         $len = strlen($prefix);
//         if (strncmp($prefix, $className, $len) === 0) {
//             // 獲取類的相對路徑
//             $relativeClass = substr($className, $len);
//             $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

//             // 如果檔案存在，則載入
//             if (file_exists($file)) {
//                 require $file;
//                 return;
//             }
//         }
//     }

//     // 可選：記錄錯誤
//     // error_log("Class $className not found in any defined directories.");
// });

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
