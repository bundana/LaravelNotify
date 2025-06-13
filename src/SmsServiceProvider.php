<?php

namespace Bundana\LaravelSmsNotify;

use Illuminate\Support\ServiceProvider;
use Bundana\LaravelSmsNotify\SmsManager;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/sms.php',
            'sms'
        );

        $this->app->singleton(SmsManager::class, function ($app) {
            return new SmsManager($app);
        });

        $this->app->singleton(SmsBuilder::class, function ($app) {
            return new SmsBuilder();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/sms.php' => config_path('sms.php'),
        ], 'config');
    }
}
