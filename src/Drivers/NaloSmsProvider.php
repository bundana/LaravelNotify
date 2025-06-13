<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use Bundana\LaravelSmsNotify\Contracts\SmsProviderInterface;
use GuzzleHttp\Client;

class NaloSmsProvider implements SmsProviderInterface
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
     * Create a new Nalo SMS provider instance.
     *
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => $config['base_url'],
            'headers' => [
                'Authorization' => 'Bearer '.$config['api_key'],
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Send the SMS message.
     */
    public function send(string $to, string $message, ?string $from = null): array
    {
        $response = $this->client->post('send', [
            'json' => [
                'key' => $this->config['api_key'],
                'sender_id' => $from ?? $this->config['sender_id'],
                'recipient' => $to,
                'message' => $message,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get the provider name.
     */
    public function getName(): string
    {
        return 'nalo';
    }
}
