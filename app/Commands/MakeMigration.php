<?php

// commands/MakeMigrationCommand.php
// namespace Commands;

namespace App\Commands;

use App\System\BaseCommand;

class MakeMigration extends BaseCommand
{
    public $group = 'Make';
    public $name = 'make:migration';
    public $description = '建立資料庫遷移檔案';

    public function run(array $params)
    {
        $migrationName = $this->getParam($params, 0, 'default_migration');
        echo "建立遷移檔案: $migrationName\n";
    }
}
