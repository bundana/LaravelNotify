<?php

namespace Bundana\LaravelSmsNotify\Drivers;

use GuzzleHttp\Client;

class MnotifyGroupProvider
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
     * Create a new Mnotify Group provider instance.
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
     * Create a new group
     * 
     * @param string $name Group name
     * @return array
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
     * 
     * @return array
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
     * 
     * @param string $groupId
     * @return array
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
     * 
     * @param string $groupId
     * @param string $name
     * @return self
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
     * 
     * @param string $groupId
     * @return self
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
     * @param string $groupId
     * @param array $contacts Array of contact numbers
     * @return self
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
     * @param string $groupId
     * @param array $contacts Array of contact numbers
     * @return self
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
     * 
     * @param string $groupId
     * @return array
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
