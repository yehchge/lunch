<?php

// namespace App\Commands;

// use CodeIgniter\CLI\BaseCommand;
// use CodeIgniter\CLI\CLI;

class AppInfo
{
    protected $group = 'Demo';
    protected $name = 'app:info';
    protected $description = 'Displays basic application information.';

    public function run(array $params)
    {

        $this->showHeader();

        CLI::write('PHP Version: ' . CLI::color(PHP_VERSION, 'yellow'));
        CLI::write('Version: ' . CLI::color(\App\Config\App::APP_VERSION, 'yellow'));
        CLI::write('APPPATH: ' . CLI::color(APPPATH, 'yellow'));
        CLI::write('SYSTEMPATH: ' . CLI::color(SYSTEMPATH, 'yellow'));
        CLI::write('ROOTPATH: ' . CLI::color(ROOTPATH, 'yellow'));
        CLI::write('Included files: ' . CLI::color(count(get_included_files()), 'yellow'));
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
