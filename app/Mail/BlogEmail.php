<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserCreditLog;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BlogEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;

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
        
        return $this->markdown("emails.blogNewsletter")
        ->from(config('mail.from.address_hello'), config('mail.from.name'))
        ->subject( $this->user->userProfile->name." | What's the deal with your ruling planet?")
        ->with(['user' => $this->user]);
    }
}
