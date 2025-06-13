<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use GuzzleHttp\Client;

class MnotifyTemplateProvider
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
     * Create a new Mnotify Template provider instance.
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
     * Set the HTTP client instance.
     *
     * @param Client $client
     * @return self
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Create a new message template
     * 
     * @param string $name Template name
     * @param string $content Template content
     * @return array
     */
    public function createTemplate(string $name, string $content): array
    {
        $response = $this->client->post('template', [
            'json' => [
                'key' => $this->config['api_key'],
                'name' => $name,
                'content' => $content,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get all message templates
     * 
     * @return array
     */
    public function getTemplates(): array
    {
        $response = $this->client->get('template', [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a specific template by ID
     * 
     * @param string $templateId
     * @return array
     */
    public function getTemplate(string $templateId): array
    {
        $response = $this->client->get("template/{$templateId}", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Update an existing template
     * 
     * @param string $templateId
     * @param string $name
     * @param string $content
     * @return self
     */
    public function updateTemplate(string $templateId, string $name, string $content): self
    {
        $this->client->put("template/{$templateId}", [
            'json' => [
                'key' => $this->config['api_key'],
                'name' => $name,
                'content' => $content,
            ],
        ]);

        return $this;
    }

    /**
     * Delete a template
     * 
     * @param string $templateId
     * @return self
     */
    public function deleteTemplate(string $templateId): self
    {
        $this->client->delete("template/{$templateId}", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return $this;
    }
}
