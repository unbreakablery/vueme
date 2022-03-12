<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Day20ClientEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $users;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $users)
    {
        $this->user = $user;
        $this->users = $users;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.20DayAfterSignupClientEmail")
        ->from(config('mail.from.address_hello'), config('mail.from.name'))
        ->subject( $this->user->userProfile->name.' | Relationship Readings... Love at Second Sight')
        ->with(['user' => $this->user, 'users' => $this->users]);
    }
}
