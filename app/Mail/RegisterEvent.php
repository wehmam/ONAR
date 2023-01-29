<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class RegisterEvent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $message;

    public function __construct($registration)
    {
        $this->message = (new MailMessage)
            ->subject("Register Event")
            ->line("Anda telah terdaftar di event " . $registration->event->eventDetail->title . " dengan Invoice " . $registration->invoice)
            ->line("silakan melanjutkan proses pembayaran")
            ->action("Payment", url("/events/pay/ONR2301290001"));
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
