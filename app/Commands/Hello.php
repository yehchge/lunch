<?php

namespace App\Commands;

use App\System\BaseCommand;

class Hello extends BaseCommand
{

    public $group = 'Demo';
    public $name = 'hello';
    public $description = 'hello';

    public function run(array $params)
    {
        echo "哈囉，" . ($params[0] ?? '世界') . "！\n";
    }
}
