<?php

namespace Bundana\LaravelSmsNotify;

use Bundana\LaravelSmsNotify\Enums\SmsProviders;
use Bundana\LaravelSmsNotify\Support\SmsMessage;
use Bundana\LaravelSmsNotify\Jobs\SendSmsJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Container\Container;

class SmsBuilder
{
    /**
     * The SMS message instance.
     *
     * @var SmsMessage
     */
    protected SmsMessage $message;

    /**
     * Create a new SMS builder instance.
     */
    public function __construct()
    {
        // Initialize the SMS message instance
        $this->message = new SmsMessage();
    }

    /**
     * Set the recipient's phone number.
     *
     * @param string $to
     * @return $this
     */
    public function to(string $to): self
    {
        $this->message->to($to);
        return $this;
    }

    /**
     * Set the message content.
     *
     * @param string $message
     * @return $this
     */
    public function message(string $message): self
    {
        $this->message->message($message);
        return $this;
    }

    /**
     * Set the sender's name or number.
     *
     * @param string $from
     * @return $this
     */
    public function from(string $from): self
    {
        $this->message->from($from);
        return $this;
    }

    /**
     * Set the SMS provider.
     *
     * @param string $provider
     * @return $this
     */
    public function provider(string $provider): self
    {
        $this->message->provider(SmsProviders::from($provider));
        return $this;
    }

    /**
     * Mark the message as queued.
     *
     * @return $this
     */
    public function queue(): self
    {
        $this->message->queue();
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
        $this->message->schedule($time);
        return $this;
    }

    /**
     * Send the SMS message.
     *
     * @return mixed
     */
    public function send()
    {
        if ($this->message->shouldQueue()) {
            $job = new SendSmsJob($this->message);

            if ($this->message->getScheduledAt()) {
                return Bus::dispatch($job->delay($this->message->getScheduledAt()));
            }

            return Bus::dispatch($job);
        }

        return Container::getInstance()->make(SmsManager::class)
            ->driver($this->message->getProvider())
            ->send(
                $this->message->getTo(),
                $this->message->getMessage(),
                $this->message->getFrom()
            );
    }
}
