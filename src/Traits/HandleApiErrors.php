<?php

namespace Inboxino\PhpApi\Traits;

use Inboxino\PhpApi\Exceptions\InboxinoApiException;
use Inboxino\PhpApi\Exceptions\InvalidTokenException;
use Inboxino\PhpApi\Exceptions\ValidationException;

trait HandleApiErrors
{
    protected function handleErrors($responseCode, $response)
    {
        switch (intval($responseCode)) {
            case 401:
                throw new InvalidTokenException($response->message);

            case 400:
                throw new ValidationException($response->message, $response->data, 400);

            default:
                throw new InboxinoApiException($response->message, $responseCode);
        }
    }
}