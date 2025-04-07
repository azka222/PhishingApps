<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendCredentials extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $password, $name, $email;
    public function __construct($password, $name, $email)
    {
        $this->password = $password;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Create a new message instance.
     */


    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Account Credentials')
            ->view('mail.newEmployee')
            ->with([
                'password' => $this->password,
                'name' => $this->name,
                'email' => $this->email,
            ]);
    }
}
