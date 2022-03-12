<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeaturesPsychics extends Mailable
{
    use Queueable, SerializesModels;

    private $psychic;

    private $user;

    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject, $psychic)
    {
        $this->user = $user;
        $this->psychic = $psychic;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->markdown("emails.featurePsychic")
        ->from(config('mail.from.address_hello'), config('mail.from.name'))
        ->subject( $this->user->userProfile->name.' | ' . $this->subject)
        ->with(['user' => $this->user, 'psychic' => User::find($this->psychic['id']), 'description' => $this->psychic['description']]);
    }
}
