<?php

namespace Bundana\LaravelSmsNotify\Jobs;

use Bundana\LaravelSmsNotify\SmsManager;
use Bundana\LaravelSmsNotify\Support\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The SMS message instance.
     */
    protected SmsMessage $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SmsMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(SmsManager $sms): void
    {
        $sms->driver($this->message->getProvider())
            ->send(
                $this->message->getTo(),
                $this->message->getMessage(),
                $this->message->getFrom()
            );
    }
}
