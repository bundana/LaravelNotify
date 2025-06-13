<?php

use Bundana\LaravelSmsNotify\Enums\SmsProviders;

return [
    /*
    |--------------------------------------------------------------------------
    | Default SMS Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default SMS provider that will be used when
    | sending SMS messages. Supported providers: "mnotify", "hubtel", "nalo"
    |
    */
    'default' => env('SMS_PROVIDER', SmsProviders::MNOTIFY->name),

    /*
    |--------------------------------------------------------------------------
    | SMS Providers
    |--------------------------------------------------------------------------
    |
    | Here you may configure the SMS providers for your application. You can
    | configure multiple providers and switch between them as needed.
    |
    */
    'drivers' => [
        'mnotify' => [
            'api_key' => env('MNOTIFY_API_KEY'),
            'sender_id' => env('MNOTIFY_SENDER_ID'),
            'base_url' => env('MNOTIFY_BASE_URL', 'https://api.mnotify.com/api/'),
            'version' => env('MNOTIFY_VERSION', 'v2'),
        ],

        'hubtel' => [
            'client_id' => env('HUBTEL_CLIENT_ID'),
            'client_secret' => env('HUBTEL_CLIENT_SECRET'),
            'sender_id' => env('HUBTEL_SENDER_ID'),
            'base_url' => env('HUBTEL_BASE_URL', 'https://smsc.hubtel.com/v1/'),
        ],

        'nalo' => [
            'api_key' => env('NALO_API_KEY'),
            'sender_id' => env('NALO_SENDER_ID'),
            'base_url' => env('NALO_BASE_URL', 'https://sms.nalosolutions.com/api/'),
        ],
    ],
];
