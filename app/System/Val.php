<?php

namespace App\System;

use Exception;

class Val
{
    public function __construct()
    {
    }

    public function __call($name, $arguments)
    {
        throw new Exception("$name does not exist inside of: ".__CLASS__);
    }

    public function minlength($data, $arg)
    {
        if (strlen($data) < $arg) {
            return "Your string can only be $arg long";
        }
    }

    public function maxlength($data, $arg)
    {
        if (strlen($data) > $arg) {
            return "Your string can only be $arg long";
        }
    }

    public function digit($data)
    {
        if (ctype_digit($data) == false) {
            return 'Your string must be a digit';
        }
    }
}
