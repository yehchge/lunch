<?php

declare(strict_types=1);

define('CI_START', microtime(true));

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';
require 'app/Config/Config.php';

use App\System\Application;
use App\System\DotEnv;

// Load environment variables from .env file
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = new DotEnv(__DIR__ . '/.env');
    $dotenv->load();
}

$app = new Application();
$app->handleRequest();
