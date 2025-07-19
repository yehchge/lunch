<?php

// 檔案：src/Core/SecurityException.php
// 自訂例外類
namespace App\System;

use Throwable;

class SecurityException extends \Exception
{

    /**
     * HTTP status code
     *
     * @var int
     */
    protected $code = 403;

    public function __construct($message, $code = 0, ?Throwable $previous = null)
    {
        if(!$code) { $code = $this->code;
        }
        parent::__construct($message, $code, $previous);
    }

}
