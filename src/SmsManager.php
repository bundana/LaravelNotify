<?php

namespace Bundana\LaravelSmsNotify;

use Bundana\LaravelSmsNotify\Contracts\SmsProviderInterface;
use Bundana\LaravelSmsNotify\Drivers\HubtelSmsProvider;
use Bundana\LaravelSmsNotify\Drivers\MnotifySmsProvider;
use Bundana\LaravelSmsNotify\Drivers\NaloSmsProvider;
use Illuminate\Support\Manager;

class SmsManager extends Manager
{
    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('sms.default');
    }

    /**
     * Create an instance of the Mnotify SMS driver.
     */
    protected function createMnotifyDriver(): MnotifySmsProvider
    {
        return new MnotifySmsProvider(
            $this->config->get('sms.drivers.mnotify')
        );
    }

    /**
     * Create an instance of the Hubtel SMS driver.
     */
    protected function createHubtelDriver(): HubtelSmsProvider
    {
        return new HubtelSmsProvider(
            $this->config->get('sms.drivers.hubtel')
        );
    }

    /**
     * Create an instance of the Nalo SMS driver.
     */
    protected function createNaloDriver(): NaloSmsProvider
    {
        return new NaloSmsProvider(
            $this->config->get('sms.drivers.nalo')
        );
    }

    /**
     * Get a driver instance.
     *
     * @param  string|null  $driver
     */
    public function driver($driver = null): SmsProviderInterface
    {
        return parent::driver($driver);
    }
}
