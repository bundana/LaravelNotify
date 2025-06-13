<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use GuzzleHttp\Client;

class MnotifyReportProvider
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
     * Create a new Mnotify Report provider instance.
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
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Get SMS Balance
     * This endpoint retrieves your SMS credit balance and bonus
     * 
     * @return array
     */
    public function getBalance(): array
    {
        $response = $this->client->get('balance', [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get Campaign Delivery Report
     * This endpoint retrieves the delivery status of your SMS messages for a specific campaign
     * 
     * @param string $campaignId
     * @return array
     */
    public function getCampaignReport(string $campaignId): array
    {
        $response = $this->client->get("campaign/{$campaignId}/status", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get Specific SMS Delivery Report
     * This endpoint retrieves delivery report for a specific SMS sent with the id as parameter
     * 
     * @param string $messageId
     * @return array
     */
    public function getMessageReport(string $messageId): array
    {
        $response = $this->client->get("status/{$messageId}", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get SMS Delivery Reports
     * This endpoint retrieves delivery reports for all SMS messages
     * 
     * @param array $filters Optional filters for the report
     * @return array
     */
    public function getDeliveryReports(array $filters = []): array
    {
        $response = $this->client->get('reports', [
            'json' => array_merge([
                'key' => $this->config['api_key'],
            ], $filters),
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get SMS Summary Report
     * This endpoint retrieves a summary of SMS messages sent
     * 
     * @param array $filters Optional filters for the report
     * @return array
     */
    public function getSummaryReport(array $filters = []): array
    {
        $response = $this->client->get('reports/summary', [
            'json' => array_merge([
                'key' => $this->config['api_key'],
            ], $filters),
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
