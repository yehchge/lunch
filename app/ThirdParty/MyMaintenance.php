<?php

/**
 * Event 網站維護時使用
 *
 * @created 2025/05/07
 */

/**
 * Check whether the site is offline or not.
 */
namespace App\ThirdParty;

class MyMaintenance
{

    public function __construct()
    {
        // log_message('debug','Accessing maintenance hook!');
    }

    public function offline_check()
    {
        $maintenance_mode = getenv('maintenance_mode');

        if($maintenance_mode==1) {
            view('maintenance');
            exit;
        }
    }
}
