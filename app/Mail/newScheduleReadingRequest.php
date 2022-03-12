<?php

namespace App\Mail;

use App\Services\NotificationsInAppUtils;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class newScheduleReadingRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $start = NotificationsInAppUtils::convertTime(
            $this->appointment->start_hour, 
            $this->appointment->user->userProfile->timezone, 
            $this->appointment->psychic->userProfile->timezone
          );         
        $this->appointment->start_hour = $start;
        return $this->markdown("emails.newScheduleReadingRequest")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject($this->appointment->psychic()->first()->UserProfile()->first()->display_name.
        ' | '.$this->appointment->user()->first()->UserProfile()->first()->name.' - Scheduled Reading Request')
        ->with(['appointment'=>$this->appointment]);        
    }
}
