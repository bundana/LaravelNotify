<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use Bundana\LaravelSmsNotify\Contracts\SmsProviderInterface;
use GuzzleHttp\Client;

class HubtelSmsProvider implements SmsProviderInterface
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
     * Create a new Hubtel SMS provider instance.
     *
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
     */
    public function getName(): string
    {
        return 'hubtel';
    }
}
