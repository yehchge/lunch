<?php

// declare(strict_types=1); // 嚴格類型

namespace App\System;

class Database
{
    
    private $pdo;

    public function __construct()
    {
        $host = getenv("DATABASE_HOST");
        $dbname = getenv("DATABASE_NAME");
        $username = getenv("DATABASE_USER");
        $password = getenv("DATABASE_PASS");

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

        try {
            $this->pdo = new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            echo "連線失敗: ". $e->getMessage();
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
