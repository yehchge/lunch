<?php

/**
 * 核心 Core
 */

class Core
{
    public function __construct(){
        $app = new \App\Config\App();

// echo "appTimeZone : ".$app->appTimezone;


        // Set default timezone on the server
        date_default_timezone_set($app->appTimezone ?? 'UTC');
    }
}
