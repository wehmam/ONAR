<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
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
            ->line('Terima kasih telah mendaftar di Event A.')
            ->line('Silahkan Lakukan Pembayaran segera, terima kasih!.')
            ->action('Klik Disini', "https://event.onar.asia");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("event@onar.asia", "ONAR.")->markdown('vendor.notifications.email', $this->message->data());
    }
}
