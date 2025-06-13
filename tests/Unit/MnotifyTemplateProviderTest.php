<?php

use Bundana\LaravelSmsNotify\Drivers\MnotifyTemplateProvider;
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

    $this->mockHandler = new MockHandler;
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);

    $this->provider = new MnotifyTemplateProvider($this->config);
    $this->provider->setClient($client);
});

test('it can create a template', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Template created successfully',
            'data' => [
                'id' => '123456789',
                'name' => 'Welcome Template',
                'content' => 'Hello {{name}}!',
            ],
        ]))
    );

    $result = $this->provider->createTemplate('Welcome Template', 'Hello {{name}}!');

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'success')
        ->toHaveKey('code', 2000)
        ->toHaveKey('message', 'Template created successfully')
        ->toHaveKey('data')
        ->and($result['data'])
        ->toHaveKey('id', '123456789')
        ->toHaveKey('name', 'Welcome Template')
        ->toHaveKey('content', 'Hello {{name}}!');
});

test('it can get all templates', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Templates retrieved successfully',
            'data' => [
                [
                    'id' => '123456789',
                    'name' => 'Welcome Template',
                    'content' => 'Hello {{name}}!',
                ],
                [
                    'id' => '987654321',
                    'name' => 'Reminder Template',
                    'content' => 'Don\'t forget {{task}}!',
                ],
            ],
        ]))
    );

    $result = $this->provider->getTemplates();

    expect($result)
        ->toBeArray()
        ->toHaveKey('status', 'success')
        ->toHaveKey('data')
        ->and($result['data'])
        ->toBeArray()
        ->toHaveCount(2)
        ->and($result['data'][0])
        ->toHaveKey('id', '123456789')
        ->toHaveKey('name', 'Welcome Template');
});

test('it can update a template', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Template updated successfully',
        ]))
    );

    $result = $this->provider->updateTemplate('123456789', 'Updated Template', 'Hi {{name}}!');

    expect($result)->toBe($this->provider);
});

test('it can delete a template', function () {
    $this->mockHandler->append(
        new Response(200, [], json_encode([
            'status' => 'success',
            'code' => 2000,
            'message' => 'Template deleted successfully',
        ]))
    );

    $result = $this->provider->deleteTemplate('123456789');

    expect($result)->toBe($this->provider);
});
