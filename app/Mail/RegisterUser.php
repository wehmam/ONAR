<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class RegisterUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $message;

    public function __construct()
    {
        $this->message = (new MailMessage)
            ->line("Terima kasih telah mendaftar di PSO Events")
            ->line("Silakan login dan mendaftar di events yang anda inginkan!")
            ->action("Login", "https://event.onar.asia/login");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("event@onar.asia", "PSO.")->markdown('vendor.notifications.email', $this->message->data());
    }
}
