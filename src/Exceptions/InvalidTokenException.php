<?php

namespace Inboxino\PhpApi\Exceptions;

class InvalidTokenException extends InboxinoApiException
{
    protected $code = 401;
    protected $message = 'Invalid token';
}