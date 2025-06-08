<?php

namespace App\Controllers;

use App\System\ViewEngine;

class Home 
{
    public function index()
    {
        include_once 'app/System/ViewEngine.php';
        return view('welcome_message');
    }

    public function welcome()
    {
        return view('old_welcome_message');
    }
}
