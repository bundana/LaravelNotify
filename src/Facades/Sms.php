<?php

namespace Bundana\LaravelSmsNotify\Facades;

use Bundana\LaravelSmsNotify\SmsBuilder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static SmsBuilder to(string $to)
 * @method static SmsBuilder message(string $message)
 * @method static SmsBuilder from(string $from)
 * @method static SmsBuilder provider(string $provider)
 * @method static SmsBuilder queue()
 * @method static SmsBuilder schedule(\DateTimeInterface $time)
 * @method static mixed send()
 *
 * @see \Bundana\LaravelSmsNotify\SmsBuilder
 */
class Sms extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return SmsBuilder::class;
    }
}
