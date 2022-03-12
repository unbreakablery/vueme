<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WeeklyHoroscopeSignEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $subjectParam;
    private $signs;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject, $signs)
    {
        $this->user = $user;
        $this->subjectParam = $subject;
        $this->signs = $signs;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.weeklyHoroscopeSignEmail")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject( $this->user->name.' , '. $this->subjectParam)
        ->with(['user' => $this->user, 'signs' => $this->signs]);
    }
}
