<?php

namespace App\Mail;

use App\Services\ApiUtils;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Subscribed extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $created = new \DateTime();
        $renew = new \DateTime($this->subscription->next_payment_at);
        $model = $this->subscription->subscription->user;

        return $this->markdown("emails.subscribe")
        ->from(config('mail.from.address'), config('mail.from.name'))
        ->subject($this->user->userProfile->name.' | VIP Access to '
        .$model->userProfile->display_name.' Confirmed')
        ->with(['user'=>$this->user, 'model' => $model, 'created' => $created, 'subscription' => $this->subscription->subscription, 'renew' => $renew->format('m-d-Y')]);
        
    }
}
