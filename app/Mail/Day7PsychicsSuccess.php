<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Day7PsychicsSuccess extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $images;
    private $titles;
    private $texts;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $images, $titles, $texts)
    {
        $this->user = $user;
        $this->images = $images;
        $this->titles = $titles;
        $this->texts = $texts;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.7daysSuccess")
        ->from(config('mail.from.address_hello'), config('mail.from.name'))
        ->subject( $this->user->userProfile->name." | Here's Your Crash Course to Crush It")
        ->with(['user' => $this->user, 'images' => $this->images, 'titles' => $this->titles, 'texts' => $this->texts]);
    }
}
