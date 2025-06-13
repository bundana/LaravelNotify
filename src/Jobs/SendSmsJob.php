<?php

namespace Bundana\LaravelSmsNotify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Bundana\LaravelSmsNotify\Support\SmsMessage;
use Bundana\LaravelSmsNotify\SmsManager;

class SendSmsJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * The SMS message instance.
     *
     * @var SmsMessage
     */
    protected SmsMessage $message;

    /**
     * Create a new job instance.
     *
     * @param SmsMessage $message
     * @return void
     */
    public function __construct(SmsMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @param SmsManager $sms
     * @return void
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
