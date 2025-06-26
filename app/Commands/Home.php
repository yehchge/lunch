<?php

namespace App\Commands;

use App\System\BaseCommand;

class Home extends BaseCommand
{
    public $group = '';
    public $name = "home";
    public $description = '';

    public function run(array $params){
        echo "Welcome to the World !!!".PHP_EOL;
    }

}
