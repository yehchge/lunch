<?php

namespace App\Models;

use App\System\Model;

class DummyTableModel extends Model
{
    public $config = [];
    public $groups = [];

    protected $table = 'dummy_table';
}
