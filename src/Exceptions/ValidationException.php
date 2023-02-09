<?php

namespace Inboxino\PhpApi\Exceptions;

use Throwable;

class ValidationException extends InvalidDataException
{
    /**
     * @var array|mixed
     */
    public $data = [];

    public function __construct($message = "", $data = [], $code = 0, Throwable $previous = null)
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }
}