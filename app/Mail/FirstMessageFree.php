<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FirstMessageFree extends Mailable
{
    use Queueable, SerializesModels;
    public $user; 
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
        return $this->markdown("emails.firstMessage")
        ->from(config('mail.from.address_hello'), config('mail.from.name'))
        ->subject($this->user->userProfile->name.' | The Universe Told Us to Give You $5 Free')
        ->with(['user'=>$this->user]);
    }
}
