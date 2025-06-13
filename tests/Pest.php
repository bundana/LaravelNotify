<?php

use Bundana\LaravelSmsNotify\Drivers\MnotifySmsProvider;
use Bundana\LaravelSmsNotify\Drivers\MnotifyTemplateProvider;
use Bundana\LaravelSmsNotify\Drivers\MnotifyGroupProvider;
use Bundana\LaravelSmsNotify\Drivers\MnotifyContactProvider;
use Bundana\LaravelSmsNotify\Drivers\MnotifyReportProvider;

uses()->beforeEach(function () {
    $this->config = [
        'api_key' => 'test_api_key',
        'base_url' => 'https://api.mnotify.com/api/',
        'sender_id' => 'TEST_SENDER',
    ];
})->in('Pest');
