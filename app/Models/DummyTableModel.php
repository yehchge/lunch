<?php

namespace App\Models;

use App\System\Model;

class DummyTableModel extends Model
{
    private $paginator;

    public $config = [];
    public $groups = [];

    protected $table = 'dummy_table';
}
