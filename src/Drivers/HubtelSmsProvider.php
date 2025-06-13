<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use GuzzleHttp\Client;
use Bundana\LaravelSmsNotify\Contracts\SmsProviderInterface;

class HubtelSmsProvider implements SmsProviderInterface
{
    /**
     * The HTTP client instance.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * The provider configuration.
     *
     * @var array
     */
    protected array $config;

    /**
     * Create a new Hubtel SMS provider instance.
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => $config['base_url'],
            'auth' => [$config['client_id'], $config['client_secret']],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Send the SMS message.
     *
     * @param string $to
     * @param string $message
     * @param string|null $from
     * @return array
     */
    public function send(string $to, string $message, ?string $from = null): array
    {
        $response = $this->client->post('messages/send', [
            'json' => [
                'From' => $from ?? $this->config['sender_id'],
                'To' => $to,
                'Content' => $message,
                'RegisteredDelivery' => true,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get the provider name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'hubtel';
    }
}
