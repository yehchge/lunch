<?php

namespace App\Models;

use App\System\Model;

class EmployeeModel extends Model
{
    protected $table            = 'employee';
    protected $primaryKey       = 'id';
    // protected $allowedFields    = ['name', 'email'];
}
