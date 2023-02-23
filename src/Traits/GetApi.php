<?php

namespace Inboxino\PhpApi\Traits;

trait GetApi
{
    use GetApiUrl;

    /**
     * @return \GuzzleHttp\Client
     */
    protected function getGuzzle($baseUrl = null): \GuzzleHttp\Client
    {
        if (! $baseUrl)
            $baseUrl = self::getApiBaseUrl();

        $client = new \GuzzleHttp\Client([
            'base_uri' => $baseUrl,
            'headers' => $this->getBaseHeaders()
        ]);

        return  $client;
    }

    /**
     * @return string[]
     */
    protected function getBaseHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($this->token)
            $headers['Authorization'] = "Bearer {$this->token}";

        return $headers;
    }


}