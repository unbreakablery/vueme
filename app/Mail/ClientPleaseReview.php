<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientPleaseReview extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $psychic)
    {
        $this->user = $user;
        $this->psychic = $psychic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.clientPleaseReview")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject($this->user->name.' | Write a review to '. $this->psychic->name)
        ->with(['user' => $this->user, 'psychic' => $this->psychic]);
    }
}
