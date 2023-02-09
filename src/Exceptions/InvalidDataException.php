<?php

namespace Inboxino\PhpApi\Exceptions;

class InvalidDataException extends InboxinoApiException
{
    protected $code = 400;
    protected $message = 'invalid data';
}