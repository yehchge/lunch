<?php

class Home 
{
    public function index()
    {
        return view('welcome_message');
    }

    public function welcome()
    {
        return view('old_welcome_message');
    }
}
