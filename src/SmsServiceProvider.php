<?php

namespace Bundana\LaravelSmsNotify;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sms.php',
            'sms'
        );

        $this->app->singleton(SmsManager::class, function ($app) {
            return new SmsManager($app);
        });

        $this->app->singleton(SmsBuilder::class, function ($app) {
            return new SmsBuilder;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/sms.php' => config_path('sms.php'),
        ], 'config');
    }
}
