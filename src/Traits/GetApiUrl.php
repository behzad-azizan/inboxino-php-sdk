<?php

namespace Inboxino\PhpApi\Traits;

trait GetApiUrl
{
    /**
     * @return string
     */
    protected static function getApiBaseUrl(): string
    {
        return 'https://back.inboxino.com/api/access-api/';
    }
}