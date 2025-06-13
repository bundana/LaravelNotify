<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use Bundana\LaravelSmsNotify\Contracts\SmsProviderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class MnotifySmsProvider implements SmsProviderInterface
{
    /**
     * The HTTP client instance.
     */
    protected Client $client;

    /**
     * The provider configuration.
     */
    protected array $config;

    /**
     * Create a new Mnotify SMS provider instance.
     *
     * @link https://readthedocs.mnotify.com/#tag/SMS/operation/campaign/sms_quick
     *
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => $config['base_url'],
            'headers' => [
                // 'Authorization' => 'Bearer ' . $config['api_key'],
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Set the HTTP client instance.
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Send a quick SMS message.
     */
    public function send(string $to, string $message, ?string $from = null): array
    {
        try {
            $response = $this->client->post('sms/send', [
                'json' => [
                    'key' => $this->config['api_key'],
                    'recipient' => [$to],
                    'sender' => $from ?? $this->config['sender_id'],
                    'message' => $message,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();

            return json_decode($response->getBody()->getContents(), true);
        } catch (ServerException $e) {
            $response = $e->getResponse();

            return json_decode($response->getBody()->getContents(), true);
        }
    }

    // /**
    //  * SendGroup Bulk SMS
    //  * Send SMS to clients/contacts using groups you created earlier which has contacts in them
    //  * @link https://readthedocs.mnotify.com/#tag/SMS/operation/campaign/sms_group
    //  * @param array $recipients
    //  * @param string $message
    //  * @param string|null $from
    //  * @return array
    //  */
    // public function sendGroup(array $recipients, string $message, ?string $from = null): array
    // {
    //     $response = $this->client->post('sms/group', [
    //         'json' => [
    //             'key' => $this->config['api_key'],
    //             'recipients' => $recipients,
    //             'sender' => $from ?? $this->config['sender_id'],
    //             'message' => $message,
    //             'is_schedule' => false,
    //         ],
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

    // /**
    //  * Sender ID Registration
    //  * Register a sender ID with MNotify to send SMS messages
    //  * @link https://readthedocs.mnotify.com/#tag/SMS/operation/sender_id/get
    //  * @param string $senderId
    //  * @return array
    //  */
    // public function registerSenderId(string $senderId, string $purpose): array
    // {
    //     $response = $this->client->post('senderid/register', [
    //         'json' => [
    //             'key' => $this->config['api_key'],
    //             'sender_name' => $senderId,
    //             'purpose' => $purpose,
    //         ],
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

    // /**
    //  * Check Sender ID Status
    //  * Check the status of a sender ID you registered with MNotify
    //  * @link https://readthedocs.mnotify.com/#tag/SMS/operation/sender_id/status
    //  * @param string $senderId
    //  * @return array
    //  */
    // public function checkSenderIdStatus(string $senderId): array
    // {
    //     $response = $this->client->get('senderid/status', [
    //         'json' => [
    //             'key' => $this->config['api_key'],
    //             'sender_name' => $senderId,
    //         ],
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

    // /**
    //  * Send SMS using a template
    //  *
    //  * @param string $to
    //  * @param string $templateId
    //  * @param array $variables Template variables to replace
    //  * @param string|null $from
    //  * @return array
    //  */
    // public function sendWithTemplate(string $to, string $templateId, array $variables = [], ?string $from = null): array
    // {
    //     $response = $this->client->post('sms/template', [
    //         'json' => [
    //             'key' => $this->config['api_key'],
    //             'recipient' => [$to],
    //             'sender' => $from ?? $this->config['sender_id'],
    //             'template_id' => $templateId,
    //             'variables' => $variables,
    //             'is_schedule' => false,
    //         ],
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

    // /**
    //  * Send bulk SMS using a template
    //  *
    //  * @param array $recipients
    //  * @param string $templateId
    //  * @param array $variables Template variables to replace
    //  * @param string|null $from
    //  * @return array
    //  */
    // public function sendGroupWithTemplate(array $recipients, string $templateId, array $variables = [], ?string $from = null): array
    // {
    //     $response = $this->client->post('sms/template/group', [
    //         'json' => [
    //             'key' => $this->config['api_key'],
    //             'recipients' => $recipients,
    //             'sender' => $from ?? $this->config['sender_id'],
    //             'template_id' => $templateId,
    //             'variables' => $variables,
    //             'is_schedule' => false,
    //         ],
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

    /**
     * Get the provider name.
     */
    public function getName(): string
    {
        return 'mnotify';
    }
}
