<?php

namespace Inboxino\PhpApi\Methods;

use Inboxino\PhpApi\Traits\GetInstance;
use Inboxino\PhpApi\Traits\GetApi;

class BaseMethod
{
    use GetInstance;

    protected ?string $token = null;

    /**
     * Set Inboxino API token
     * @param string $token
     * @return $this
     */
    public function setApiToken(string $token)
    {
        $this->token = $token;

        return $this;
    }
}