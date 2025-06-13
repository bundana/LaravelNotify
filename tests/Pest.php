<?php

uses()->beforeEach(function () {
    $this->config = [
        'api_key' => 'test_api_key',
        'base_url' => 'https://api.mnotify.com/api/',
        'sender_id' => 'TEST_SENDER',
    ];
})->in('Pest');
