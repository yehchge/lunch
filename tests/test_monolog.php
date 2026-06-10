#!/usr/bin/php
<?php

/**
 * test monolog
 * @useage composer install
 *         composer require monolog/monolog
 * @created 2026/06/10
 */
declare(strict_types=1); // 嚴格類型

// 切換到當前腳本目錄, 顯示目前腳本目錄 getcwd()
chdir(__DIR__);

require '../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

$dateFormat = "Y-m-d H:i:s";

// $output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
$output = "[%datetime%] %channel%.%level_name%: %message%\n";

$formatter = new LineFormatter($output, $dateFormat);

// create a log channel
$log = new Logger(basename(__FILE__,'.php'));
// $handler = new StreamHandler('./test_monolog.log', Logger::WARNING);
$handler = new RotatingFileHandler('./test_monolog.log', 90, Logger::DEBUG);
$handler->setFormatter($formatter);
$log->pushHandler($handler);

$log->warning('這是一筆警告日誌');
$log->error('這是一筆錯誤日誌');
$log->info('這是一筆資訊日誌');

$log->info("This file has been executed.");
