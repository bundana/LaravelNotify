<?php

namespace Bundana\LaravelSmsNotify\Contracts;

interface SmsProviderInterface
{
    /**
     * Send the SMS message.
     *
     * @param string $to
     * @param string $message
     * @param string|null $from
     * @return array
     */
    public function send(string $to, string $message, ?string $from = null): array;

    /**
     * Get the provider name.
     *
     * @return string
     */
    public function getName(): string;
}
