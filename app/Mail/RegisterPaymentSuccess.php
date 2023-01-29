<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;


class RegisterPaymentSuccess extends Mailable
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
        $date = \Carbon\Carbon::parse($registration->event->eventDetail->event_date)->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);

        $this->message = (new MailMessage)
            ->subject("Invoice Payment " . $registration->invoice)
            ->line("Terima kasih, anda telah melakukan Pembayaran")
            ->line("Invoice untuk event " . $registration->event->eventDetail->title  . " ")
            ->line("Pada tanggal " . $date->format('l, j F Y'))
            ->line("Jam " . $registration->event->eventDetail->start_hour . " - " . $registration->event->eventDetail->end_hour);
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
