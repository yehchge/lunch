<?php

class Home 
{
    public $start_time;

    public function index()
    {
        return view('welcome_message');
    }

    public function welcome()
    {
        return view('old_welcome_message');
    }
}
