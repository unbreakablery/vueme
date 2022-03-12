<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AfterRegister24Hour extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.24HourAfterRegister")
        ->from(config('mail.from.address_hello'), config('mail.from.name'))
        ->subject( $this->user->userProfile->name.' | Be a Big Success, Do These Small Things')
        ->with(['user' => $this->user]);
    }
}
