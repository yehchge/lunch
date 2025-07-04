<?php

/**
 * JWT API User
 *
 * @ref     https://www.binaryboxtuts.com/php-tutorials/codeigniter-4-json-web-tokenjwt-authentication/
 *      https://medium.com/geekculture/codeigniter-4-tutorial-restful-api-jwt-authentication-d5963d797ec4
 * @created 2022/12/22
 */

namespace App\Models;

use App\System\Model;

class ApiUserModel extends Model
{
    protected $table            = 'api_users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['email', 'password'];
}
