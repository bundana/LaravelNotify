<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use GuzzleHttp\Client;

class MnotifyContactProvider
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
     * Create a new Mnotify Contact provider instance.
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
     * Create a new contact
     * 
     * @param string $phone Contact phone number
     * @param string|null $name Contact name
     * @param string|null $email Contact email
     * @return array
     */
    public function createContact(string $phone, ?string $name = null, ?string $email = null): array
    {
        $response = $this->client->post('contact', [
            'json' => [
                'key' => $this->config['api_key'],
                'phone' => $phone,
                'name' => $name,
                'email' => $email,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create multiple contacts
     * 
     * @param array $contacts Array of contacts with phone, name, and email
     * @return array
     */
    public function createContacts(array $contacts): array
    {
        $response = $this->client->post('contact/bulk', [
            'json' => [
                'key' => $this->config['api_key'],
                'contacts' => $contacts,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get all contacts
     * 
     * @return array
     */
    public function getContacts(): array
    {
        $response = $this->client->get('contact', [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a specific contact by ID
     * 
     * @param string $contactId
     * @return array
     */
    public function getContact(string $contactId): array
    {
        $response = $this->client->get("contact/{$contactId}", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Update a contact
     * 
     * @param string $contactId
     * @param string $phone
     * @param string|null $name
     * @param string|null $email
     * @return self
     */
    public function updateContact(string $contactId, string $phone, ?string $name = null, ?string $email = null): self
    {
        $this->client->put("contact/{$contactId}", [
            'json' => [
                'key' => $this->config['api_key'],
                'phone' => $phone,
                'name' => $name,
                'email' => $email,
            ],
        ]);

        return $this;
    }

    /**
     * Delete a contact
     * 
     * @param string $contactId
     * @return self
     */
    public function deleteContact(string $contactId): self
    {
        $this->client->delete("contact/{$contactId}", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return $this;
    }

    /**
     * Delete multiple contacts
     * 
     * @param array $contactIds Array of contact IDs to delete
     * @return self
     */
    public function deleteContacts(array $contactIds): self
    {
        $this->client->delete('contact/bulk', [
            'json' => [
                'key' => $this->config['api_key'],
                'contacts' => $contactIds,
            ],
        ]);

        return $this;
    }

    /**
     * Search contacts
     * 
     * @param string $query Search query
     * @return array
     */
    public function searchContacts(string $query): array
    {
        $response = $this->client->get('contact/search', [
            'json' => [
                'key' => $this->config['api_key'],
                'query' => $query,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
