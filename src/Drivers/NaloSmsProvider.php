<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use GuzzleHttp\Client;
use Bundana\LaravelSmsNotify\Contracts\SmsProviderInterface;

class NaloSmsProvider implements SmsProviderInterface
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
     * Create a new Nalo SMS provider instance.
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => $config['base_url'],
            'headers' => [
                'Authorization' => 'Bearer ' . $config['api_key'],
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
     *
     * @return string
     */
    public function getName(): string
    {
        return 'nalo';
    }
}
