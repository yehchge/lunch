<?php

declare(strict_types=1);

namespace App\System;

use Throwable;

/**
 * 自定義路由異常類別
 */
class RouterException extends \Exception
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
