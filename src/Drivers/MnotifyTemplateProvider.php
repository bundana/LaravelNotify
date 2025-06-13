<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use GuzzleHttp\Client;

class MnotifyTemplateProvider
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
     * Create a new Mnotify Template provider instance.
     *
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
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Create a new message template
     *
     * @param  string  $name  Template name
     * @param  string  $content  Template content
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
