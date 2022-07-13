<?php

namespace App\Notifications;

use App\Models\Receivingreports;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OpmsNotification extends Notification
{
    use Queueable;
    public $ftype, $message, $link, $status;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ftype, $message, $link, $status)
    {
        $this->ftype = $ftype;
        $this->message =  $message;
        $this->link = $link;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //     ->line('The introduction to the notification.')
        //     ->action('Notification Action', url('/'))
        //     ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->ftype,
            'message' => $this->message,
            'link' => $this->link,
            'status' => $this->status
        ];
    }
}
