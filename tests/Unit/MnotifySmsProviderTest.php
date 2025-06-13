<?php

use Bundana\LaravelSmsNotify\Drivers\MnotifySmsProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

beforeEach(function () {
    $this->config = [
        'api_key' => '0WCbuaXMvcJibCMCniFufvKYK',
        'base_url' => 'https://api.mnotify.com/api/',
        'sender_id' => 'Pollvite',
    ];

    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);

    $this->provider = new MnotifySmsProvider($this->config);
    $this->provider->setClient($client);
});

test('it can send quick sms', function () {
    // Mock successful response
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Message sent successfully',
            'data' => [
                'message_id' => '123456789',
                'recipient' => '0542345921',
                'sender' => 'TEST_SENDER',
            ]
        ]))
    );

    // echo the response
    $result = $this->provider->send(
        '0542345921',
        'Hello, this is a test message!'
    );

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'success')
        ->toHaveKey('code', 2000)
        ->toHaveKey('message', 'Message sent successfully')
        ->toHaveKey('data')
        ->and($result['data'])
        ->toHaveKey('message_id', '123456789')
        ->toHaveKey('recipient', '0542345921')
        ->toHaveKey('sender', 'TEST_SENDER');
});

test('it can send quick sms with custom sender', function () {
    // Mock successful response
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Message sent successfully',
            'data' => [
                'message_id' => '123456789',
                'recipient' => '0542345921',
                'sender' => 'CUSTOM_SENDER',
            ]
        ]))
    );

    $result = $this->provider->send(
        '0542345921',
        'Hello, this is a test message!',
        'CUSTOM_SENDER'
    );

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'success')
        ->toHaveKey('data')
        ->and($result['data'])
        ->toHaveKey('sender', 'CUSTOM_SENDER');
});

test('it handles api error response', function () {
    // Mock error response
    $this->mockHandler->append(
        new Response(400, [], json_encode([
            'status' => 'error',
            'code' => 4000,
            'message' => 'Invalid phone number',
            'data' => null
        ]))
    );

    $result = $this->provider->send(
        'invalid_number',
        'Hello, this is a test message!'
    );

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'error')
        ->toHaveKey('code', 4000)
        ->toHaveKey('message', 'Invalid phone number')
        ->toHaveKey('data', null);
});

test('it handles network error', function () {
    // Mock network error
    $this->mockHandler->append(
        new Response(500, [], json_encode([
            'status' => 'error',
            'code' => 5000,
            'message' => 'Internal server error',
            'data' => null
        ]))
    );

    $result = $this->provider->send(
        '0542345921',
        'Hello, this is a test message!'
    );

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'error')
        ->toHaveKey('code', 5000)
        ->toHaveKey('message', 'Internal server error')
        ->toHaveKey('data', null);
}); 