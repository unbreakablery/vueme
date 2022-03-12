<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FirstPurchaseCredits extends Mailable
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
        return $this->markdown("emails.purchaseFirstCredits")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject( $this->user->userProfile->name.' | Clarity Starts Here… give it a little click!')
        ->with(['user' => $this->user]);
    }
}
