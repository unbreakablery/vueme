<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BeginYourReadingNow extends Mailable
{
    use Queueable, SerializesModels;
    public  $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_1_1_chat_request)
    {
        $this->user_1_1_chat_request = $user_1_1_chat_request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.beginYourReading")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject($this->user_1_1_chat_request->user()->first()->UserProfile()->first()->name.' | Begin Your Reading Now!')
        ->with(['user_chat_request'=>$this->user_1_1_chat_request]);
    }
}
