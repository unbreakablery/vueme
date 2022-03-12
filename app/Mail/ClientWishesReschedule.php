<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientWishesReschedule extends Mailable
{
    use Queueable, SerializesModels;
     public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($new_appointment,$old_appointment)
    {
        $this->new_appointment = $new_appointment;
        $this->old_appointment = $old_appointment;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.psychicClientWishesReschedule")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject($this->new_appointment->psychic()->first()->UserProfile()->first()->display_name.
        ' | '.$this->new_appointment->user()->first()->UserProfile()->first()->name.' Wishes to Reschedule ')
        ->with(['new_appointment'=>$this->new_appointment,'old_appointment'=>$this->old_appointment]);
    }
}
