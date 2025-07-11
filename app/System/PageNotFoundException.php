<?php

namespace App\System;

class PageNotFoundException extends \Exception
{

    /**
     * HTTP status code
     *
     * @var int
     */
    protected $code = 404;

    public function __construct($message, $code = 0, ?Throwable $previous = null)
    {
        if(!$code) { $code = $this->code;
        }
        parent::__construct($message, $code, $previous);
    }

}
