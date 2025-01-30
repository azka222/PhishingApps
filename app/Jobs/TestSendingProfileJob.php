<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TestSendingProfileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $targetEmail;
    protected $targetName;
    protected $httpHeaders;

    public function __construct($targetEmail, $targetName, $httpHeaders = [])
    {
        $this->targetEmail = $targetEmail;
        $this->targetName = $targetName;
        $this->httpHeaders = $httpHeaders;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw('This is a test email to validate the SMTP configuration.', function ($message) {
            $message->to($this->targetEmail)
                ->subject('Hi ' . $this->targetName . ', Test Email from Gophish Configuration');

            if (!empty($this->httpHeaders)) {
                foreach ($this->httpHeaders as $header => $value) {
                    if (is_array($value)) {
                        $value = implode(', ', $value);
                    }
                    $message->getHeaders()->addTextHeader($header, (string) $value);
                }
            }
        });
    }
}

