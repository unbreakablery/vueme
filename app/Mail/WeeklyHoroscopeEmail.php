<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WeeklyHoroscopeEmail extends Mailable
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
        $dates = ['(Mar 21 - Apr 19)', '(Apr 20 - May 20)', '(May 21 - Jun 20)', '(Jun 21 - Jul 22)', '(Jul 23 - Aug 22)', '(Aug 23 - Sep 22)',
     '(Sep 23 - Oct 22)', '(Oct 23 - Nov 21)','(Nov 22 - Dec 21)', '(Dec 22 - Jan 19)', '(Jan 20 - Feb 18)', '(Feb 19 - Mar 20)'];
    $images = [2,4,5,6,7,8,9,10,11,12,13,14];
    $backgrounds = [
        '',
        'transparent linear-gradient(48deg, #91EAE4 0%, #86A8E7 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(231deg, #C0D162B3 0%, #F2FDFF 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(50deg, #FBFFE3 0%, #FFAF91 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(230deg, #FFCABE 0%, #BFFFEB 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(228deg, #FFA0CC 0%, #BBD9FD 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(50deg, #36D1DC4D 0%, #5B86E580 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(50deg, #BDA8614D 0%, #FF000073 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(50deg, #DAF4EE 0%, #DEE2FC 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(49deg, #FF58584D 0%, #00FFF580 100%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(231deg, #F2C2E5 100%, #F88ED7 0%) 0% 0% no-repeat padding-box;',
        'transparent linear-gradient(50deg, #F0E5CF 100%, #CEFF00 0%) 0% 0% no-repeat padding-box;'
    ];    
    
        return $this->markdown("emails.weeklyHoroscopeEmail")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject( $this->user->userProfile->name.' | '. $this->subjectParam)
        ->with(['user' => $this->user, 'signs' => $this->signs, 'dates' => $dates, 'images' => $images, 'backgrounds' => $backgrounds]);
    }
}
