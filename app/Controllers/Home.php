<?php

namespace App\Controllers;

class Home 
{
    public function index()
    {
        // if (function_exists('redirect')) {
        //     $reflection = new \ReflectionFunction('redirect');
        //     echo 'redirect() defined in: ' . $reflection->getFileName() . ':' . $reflection->getStartLine();
        //     exit;
        // }

        return view('welcome_message');
    }

    public function welcome()
    {
        return view('old_welcome_message');
    }
}
