<?php

use Bundana\LaravelSmsNotify\Drivers\MnotifyGroupProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

beforeEach(function () {
    $this->config = [
        'api_key' => '0WCbuaXMvcJibCMCniFufvKYK',
        'base_url' => 'https://api.mnotify.com/api/',
        'sender_id' => 'Pollvite'
    ];

    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);

    $this->provider = new MnotifyGroupProvider($this->config);
    $this->provider->setClient($client);
});

test('it can create a group', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Group created successfully',
            'data' => [
                'id' => '123456789',
                'name' => 'VIP Customers'
            ]
        ]))
    );

    $result = $this->provider->createGroup('VIP Customers');

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'success')
        ->toHaveKey('code', 2000)
        ->toHaveKey('message', 'Group created successfully')
        ->toHaveKey('data')
        ->and($result['data'])
        ->toHaveKey('id', '123456789')
        ->toHaveKey('name', 'VIP Customers');
});

test('it can get all groups', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Groups retrieved successfully',
            'data' => [
                [
                    'id' => '123456789',
                    'name' => 'VIP Customers'
                ],
                [
                    'id' => '987654321',
                    'name' => 'Regular Customers'
                ]
            ]
        ]))
    );

    $result = $this->provider->getGroups();

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'success')
        ->toHaveKey('data')
        ->and($result['data'])
        ->toBeArray()
        ->toHaveCount(2)
        ->and($result['data'][0])
        ->toHaveKey('id', '123456789')
        ->toHaveKey('name', 'VIP Customers');
});

test('it can add contacts to a group', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Contacts added successfully'
        ]))
    );

    $result = $this->provider->addContactsToGroup('123456789', ['0542345921', '0542345922']);

    expect($result)->toBe($this->provider);
});

test('it can remove contacts from a group', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Contacts removed successfully'
        ]))
    );

    $result = $this->provider->removeContactsFromGroup('123456789', ['0542345921']);

    expect($result)->toBe($this->provider);
});

test('it can get group contacts', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Group contacts retrieved successfully',
            'data' => [
                '0542345921',
                '0542345922'
            ]
        ]))
    );

    $result = $this->provider->getGroupContacts('123456789');

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'success')
        ->toHaveKey('data')
        ->and($result['data'])
        ->toBeArray()
        ->toHaveCount(2)
        ->toContain('0542345921', '0542345922');
});
