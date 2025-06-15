<?php

namespace App\Controllers;

use App\Models\DummyTableModel;
use App\System\CRequest;

class Mvc
{
    public function index()
    {
        return view('mvc/header', ['title' => 'Create a news item'])
            . view('mvc/success')
            . view('mvc/footer');
    }
}