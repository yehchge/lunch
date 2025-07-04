<?php

// commands/MakeMigrationCommand.php
// namespace Commands;

namespace App\Commands;

use App\System\BaseCommand;

class MakeModel extends BaseCommand
{
    public $group = 'Make';
    public $name = 'make:model';
    public $description = '建立Model檔案';

    public function run(array $params)
    {
        $migrationName = $this->getParam($params, 0, 'default_model');
        echo "建立Model檔案: $migrationName\n";
    }
}
