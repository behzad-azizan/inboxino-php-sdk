<?php

namespace Inboxino\PhpApi\Methods;

use Inboxino\PhpApi\Traits\GetApi;
use Inboxino\PhpApi\Traits\HandleApiErrors;

class UploadFile extends BaseMethod
{
    use GetApi, HandleApiErrors;

    private ?string $filePath = null;
    private string $uploadType = '';

    public function setFilePath(string $filePath): UploadFile
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function setUploadType(string $uploadType)
    {
        $this->uploadType = $uploadType;

        return $this;
    }

    public function upload()
    {
        $api = $this->getGuzzle();
        $options = [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($this->filePath, 'r')
                ]
            ]
        ];

        try {
            $uri = 'upload';
            if ($this->uploadType)
                $uri .= "/{$this->uploadType}";

            $out = $api->post($uri, $options);
            $out = $out->getBody()->getContents();
            return json_decode($out);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseCode = $response->getStatusCode();
            $responseBody = json_decode($response->getBody()->getContents());
            $this->handleErrors($responseCode, $responseBody);
        }
    }
}