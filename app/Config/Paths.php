<?php

namespace App\Config;

class Paths
{
    public string $appDirectory = __DIR__ . '/..';
    public string $writableDirectory = __DIR__ . '/../../writable';
    public string $viewDirectory = __DIR__ . '/../Views';

    public function definePathConstants(): void
    {
        // The path to the application directory.
        if (! defined('APPPATH')) {
            define('APPPATH', realpath(rtrim($this->appDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
        }

        // The path to the project root directory. Just above APPPATH.
        if (! defined('ROOTPATH')) {
            define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
        }

        // The path to the writable directory.
        if (! defined('WRITEPATH')) {
            $writePath = realpath(rtrim($this->writableDirectory, '\\/ '));

            if ($writePath === false) {
                header('HTTP/1.1 503 Service Unavailable.', true, 503);
                echo 'The WRITEPATH is not set correctly.';

                // EXIT_ERROR is not yet defined
                exit(1);
            }
            define('WRITEPATH', $writePath . DIRECTORY_SEPARATOR);
        }
    }
}
