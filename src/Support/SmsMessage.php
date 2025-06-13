<?php

namespace Bundana\LaravelSmsNotify\Support;

use Bundana\LaravelSmsNotify\Enums\SmsProviders;

class SmsMessage
{
    /**
     * The recipient's phone number.
     * eg: 233540000000
     * @var string
     */
    protected string $to;

    /**
     * The message content.
     * eg: "Hello, this is a test message"
     * @var string
     */
    protected string $message;

    /**
     * The sender's name or number.
     * eg: "233540000000"
     * @var string|null
     */
    protected ?string $from = null;

    /**
     * The SMS provider to use.
     * eg: SmsProviders::MNOTIFY or mnotify
     * @var SmsProviders|null
     */
    protected ?SmsProviders $provider = null;

    /**
     * Whether the message should be queued.
     * eg: true
     * @var bool
     */
    protected bool $shouldQueue = false;

    /**
     * The scheduled time for the message.
     * eg: "2025-01-01 12:00:00"
     * @var \DateTimeInterface|null
     */
    protected ?\DateTimeInterface $scheduledAt = null;

    /**
     * Set the recipient's phone number.
     * eg: "233540000000"
     * @param string $to
     * @return $this
     */
    public function to(string $to): self
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Set the message content.
     * eg: "Hello, this is a test message"
     * @param string $message
     * @return $this
     */
    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set the sender's name or number.
     * eg: "Bundana"
     * @param string $from
     * @return $this
     */
    public function from(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Set the SMS provider.
     * eg: SmsProviders::MNOTIFY or mnotify
     * @param SmsProviders $provider
     * @return $this
     */
    public function provider(SmsProviders $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * Mark the message as queued.
     * eg: true     
     * @return $this
     */
    public function queue(): self
    {
        $this->shouldQueue = true;
        return $this;
    }

    /**
     * Schedule the message for a specific time.
     *
     * @param \DateTimeInterface $time
     * @return $this
     */
    public function schedule(\DateTimeInterface $time): self
    {
        $this->scheduledAt = $time;
        return $this;
    }

    /**
     * Get the recipient's phone number.
     *
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * Get the message content.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the sender's name or number.
     *
     * @return string|null
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * Get the SMS provider.
     *
     * @return SmsProviders|null
     */
    public function getProvider(): ?SmsProviders
    {
        return $this->provider;
    }

    /**
     * Check if the message should be queued.
     *
     * @return bool
     */
    public function shouldQueue(): bool
    {
        return $this->shouldQueue;
    }

    /**
     * Get the scheduled time.
     *
     * @return \DateTimeInterface|null
     */
    public function getScheduledAt(): ?\DateTimeInterface
    {
        return $this->scheduledAt;
    }
}
