<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupkeyEmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $skey;
    protected $email;
    protected $role;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($skey, $email, $role)
    {
        $this->skey = $skey;
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('abc_info@gmail.com')
            ->subject('Registration System – DLSU-D Property Section OPMS Sign Up Key')
            ->view('emails.signupkeyEmail')
            ->with([
                'role' => $this->role,
                'skey' => $this->skey,
                'email' => $this->email,
            ]);
    }
}
