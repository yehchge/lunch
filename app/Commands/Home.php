<?php

class Home
{
    public function run(){
        $this->showHeader();
        echo "Welcome to the World !!!".PHP_EOL;
    }

    public function showHeader(bool $suppress = false)
    {
        if ($suppress) {
            return;
        }

        CLI::newLine();

        CLI::write(sprintf(
            'Core v%s Command Line Tool - Server Time: %s UTC%s',
            \App\Config\App::APP_VERSION,
            date('Y-m-d H:i:s'),
            date('P'),
        ), 'green');
        CLI::newLine();
    }
}
