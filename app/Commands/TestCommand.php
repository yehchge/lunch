<?php

// commands/TestCommand.php
// namespace Commands;

namespace App\Commands;

use App\System\BaseCommand;

class TestCommand extends BaseCommand
{
    public $group = 'Test';
    public $name = 'test';
    public $description = '這是一個測試命令';

    public function run(array $params)
    {
        echo "執行測試命令\n";
    }
}
