<?php

namespace Bundana\LaravelSmsNotify\Contracts;

interface SmsProviderInterface
{
    /**
     * Send the SMS message.
     */
    public function send(string $to, string $message, ?string $from = null): array;

    /**
     * Get the provider name.
     */
    public function getName(): string;
}
