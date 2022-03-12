<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientReadingBooked extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
      
        $this->appointment = $appointment;
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.clientReadingBooked")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject(' Your Reading With ' .$this->appointment->psychic()->first()->UserProfile()->first()->display_name. ' is Booked!')
        ->with(['appointment'=>$this->appointment]);
    }
}
