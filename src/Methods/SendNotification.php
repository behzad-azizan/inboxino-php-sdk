<?php

namespace Inboxino\PhpApi\Methods;

use Inboxino\PhpApi\Exceptions\InvalidDataException;
use Inboxino\PhpApi\Traits\GetApi;
use Inboxino\PhpApi\Traits\HandleApiErrors;

class SendNotification extends BaseMethod
{
    use GetApi, HandleApiErrors;

    const MESSAGE_TYPE_TEXT = 'message';
    const MESSAGE_TYPE_IMAGE = 'image';
    const MESSAGE_TYPE_VIDEO = 'video';
    const MESSAGE_TYPE_FILE = 'file';

    const PLATFORM_WHATSAPP = 'whatsapp';
    const PLATFORM_TELEGRAM = 'telegram';

    private array $messages;
    /**
     * @var array|false|mixed|string[]
     */
    private $recipients = [];
    /**
     * @var array|false|mixed|string[]
     */
    private $platforms = [self::PLATFORM_WHATSAPP];

    /**
     * @var mixed|null
     */
    private $addCountryCode;

    /**
     * @param array $messages
     * @return $this
     */
    public function setMessages(array $messages): SendNotification
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * @param string|array $recipients
     * @param string|null $addCountryCode
     * @return $this
     */
    public function setRecipients($recipients, string $addCountryCode = null): SendNotification
    {
        if (! is_array($recipients))
            $recipients = explode(',', strval($recipients));

        if ($addCountryCode) {
            foreach ($recipients as &$recipient)
                $recipient = $addCountryCode . $recipient;
        }
        $this->recipients = $recipients;
        $this->addCountryCode = $addCountryCode;

        return $this;
    }

    /**
     * @param string|array $platforms
     * @return $this
     */
    public function setPlatforms($platforms): SendNotification
    {
        if (! is_array($platforms))
            $platforms = explode(',', strval($platforms));

        $this->platforms = $platforms;

        return $this;
    }

    public function send()
    {
        $api = $this->getGuzzle();
        $messages = $this->messages;
        $options = [
            'form_params' => [
                'platforms' => $this->platforms
            ]
        ];
        foreach ($messages as $key => $message) {
             try {
                 $options['form_params']['type'] = 'notification';
                 $options['form_params']["messages[{$key}][message_type]"] = $message['message_type'];
                 $options['form_params']["messages[{$key}][message]"] = $message['message'];

                 if (isset($message['attachment_file']) && $message['attachment_file'])
                     $options['form_params']["messages[{$key}][attachment_file]"] = $message['attachment_file'];

             } catch (\Exception $exception) {
                 throw new InvalidDataException();
             }
        }

        foreach ($this->recipients as $key => $recipient)
            $options['form_params']["recipients[{$key}]"] = $recipient;

        try {
            $out = $api->post('message/send', $options);
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