<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendCredentials;

class SendAccountCredentials implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $password;
    protected $name;
    public function __construct(string $email, string $password, string $name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }
 

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      

        Mail::to($this->email)->send(new sendCredentials($this->password, $this->name, $this->email));
    }
}
