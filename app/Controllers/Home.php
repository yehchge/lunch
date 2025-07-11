<?php

namespace App\Controllers;

/**
 * Home controller
 */
class Home
{
    /**
     * Index method
     *
     * @return string
     */
    public function index()
    {
        // if (function_exists('redirect')) {
        //     $reflection = new \ReflectionFunction('redirect');
        //     echo 'redirect() defined in: ' . $reflection->getFileName() . ':' . $reflection->getStartLine();
        //     exit;
        // }

        return view('welcome_message');
    }

    /**
     * Welcome method
     *
     * @return string
     */
    public function welcome()
    {
        return view('old_welcome_message');
    }
}
