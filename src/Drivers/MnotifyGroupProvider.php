<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use GuzzleHttp\Client;

class MnotifyGroupProvider
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
     * Create a new Mnotify Group provider instance.
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
     * Create a new group
     *
     * @param  string  $name  Group name
     */
    public function createGroup(string $name): array
    {
        $response = $this->client->post('group', [
            'json' => [
                'key' => $this->config['api_key'],
                'name' => $name,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get all groups
     */
    public function getGroups(): array
    {
        $response = $this->client->get('group', [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get a specific group by ID
     */
    public function getGroup(string $groupId): array
    {
        $response = $this->client->get("group/{$groupId}", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Update a group
     */
    public function updateGroup(string $groupId, string $name): self
    {
        $this->client->put("group/{$groupId}", [
            'json' => [
                'key' => $this->config['api_key'],
                'name' => $name,
            ],
        ]);

        return $this;
    }

    /**
     * Delete a group
     */
    public function deleteGroup(string $groupId): self
    {
        $this->client->delete("group/{$groupId}", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return $this;
    }

    /**
     * Add contacts to a group
     *
     * @param  array  $contacts  Array of contact numbers
     */
    public function addContactsToGroup(string $groupId, array $contacts): self
    {
        $this->client->post("group/{$groupId}/contacts", [
            'json' => [
                'key' => $this->config['api_key'],
                'contacts' => $contacts,
            ],
        ]);

        return $this;
    }

    /**
     * Remove contacts from a group
     *
     * @param  array  $contacts  Array of contact numbers
     */
    public function removeContactsFromGroup(string $groupId, array $contacts): self
    {
        $this->client->delete("group/{$groupId}/contacts", [
            'json' => [
                'key' => $this->config['api_key'],
                'contacts' => $contacts,
            ],
        ]);

        return $this;
    }

    /**
     * Get all contacts in a group
     */
    public function getGroupContacts(string $groupId): array
    {
        $response = $this->client->get("group/{$groupId}/contacts", [
            'json' => [
                'key' => $this->config['api_key'],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
