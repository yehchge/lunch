<?php

namespace App\Models;

use App\System\Model;

class MvcUserModel extends Model
{
    protected $table = 'mvc_user';
    protected $primaryKey = 'userid';
    protected $allowedFields    = ['login', 'password', 'role', 'login_session'];
}
