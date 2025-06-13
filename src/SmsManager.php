<?php

namespace Bundana\LaravelSmsNotify;

use Illuminate\Support\Manager;
use Bundana\LaravelSmsNotify\Contracts\SmsProviderInterface;
use Bundana\LaravelSmsNotify\Drivers\MnotifySmsProvider;
use Bundana\LaravelSmsNotify\Drivers\HubtelSmsProvider;
use Bundana\LaravelSmsNotify\Drivers\NaloSmsProvider;

class SmsManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('sms.default');
    }

    /**
     * Create an instance of the Mnotify SMS driver.
     *
     * @return MnotifySmsProvider
     */
    protected function createMnotifyDriver(): MnotifySmsProvider
    {
        return new MnotifySmsProvider(
            $this->config->get('sms.drivers.mnotify')
        );
    }

    /**
     * Create an instance of the Hubtel SMS driver.
     *
     * @return HubtelSmsProvider
     */
    protected function createHubtelDriver(): HubtelSmsProvider
    {
        return new HubtelSmsProvider(
            $this->config->get('sms.drivers.hubtel')
        );
    }

    /**
     * Create an instance of the Nalo SMS driver.
     *
     * @return NaloSmsProvider
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
     * @param string|null $driver
     * @return SmsProviderInterface
     */
    public function driver($driver = null): SmsProviderInterface
    {
        return parent::driver($driver);
    }
}
