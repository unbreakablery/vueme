<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserTopRatePsychics extends Mailable
{
    use Queueable, SerializesModels;

    private $models;

    private $user;

    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject, $models)
    {
        $this->subject = $subject;
        $this->models = $models;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.userTopRatePsychics")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject( $this->user->userProfile->name.' | ' . $this->subject)
        ->with(['user' => $this->user, 'users' => $this->models]);
    }
}
