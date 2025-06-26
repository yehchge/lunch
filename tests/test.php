<?php

require '../app/Config/Config.php';

$dbms   = 'mysql'; // 資料庫類型
$host   = getenv("DATABASE_HOST"); // 資料庫主機名稱
$dbName = getenv("DATABASE_NAME"); // 資料庫名稱
$user   = getenv("DATABASE_USER"); // 連線帳號
$pass   = getenv("DATABASE_PASS"); // 連線密碼
$dsn    = "$dbms:host=$host;dbname=$dbName";

try {
    $dbh = new PDO($dsn, $user, $pass);
    echo "資料庫連線成功".PHP_EOL;
    $dbh = null;
} catch (\PDOException $e) {
    die("Error!: " . $e->getMessage() . PHP_EOL);
}

$db = new \PDO($dsn, $user, $pass, array(\PDO::ATTR_PERSISTENT => true));
