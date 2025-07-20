<?php

define('PATH_ROOT', realpath(__DIR__ . '/..'));
define('APPPATH', PATH_ROOT . '/app/');
define('ROOTPATH', PATH_ROOT . '/');
define('WRITEPATH', PATH_ROOT . '/writable/');
define('SYSTEMPATH', PATH_ROOT . '/app/System/');
define('BASE_URL', 'http://localhost/');
define('CI_START', microtime(true));

// Mock database constants if they are used
define('DB_HOST', 'localhost');
define('DB_NAME', 'testdb');
define('DB_USER', 'user');
define('DB_PASS', 'pass');
define('DB_TYPE', 'mysql');
