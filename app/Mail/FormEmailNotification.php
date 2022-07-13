<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormEmailNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $form_type, $form_number, $subject, $link;
    public $s;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $form_type, $form_number, $link, $s)
    {
        $this->form_type = $form_type;
        $this->form_number = $form_number;
        $this->subject = $subject;
        $this->link = $link;
        $this->s = $s;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('abc_info@gmail.com')
            ->subject($this->subject)
            ->view('emails.formEmail')
            ->with([
                'form_type' => $this->form_type,
                'form_number' => $this->form_number,
                'subject' => $this->subject,
                'link' => $this->link,
                's' => $this->s,
            ]);
    }
}
