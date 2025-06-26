<?php

/**
 * 核心 Core
 */

namespace App\System;

class Core
{
    public function __construct(){
        $app = new \App\Config\App();

        // Set default timezone on the server
        date_default_timezone_set($app->appTimezone ?? 'UTC');
    }
}
