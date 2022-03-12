<?php
namespace App\Services\Pusher;

use App\Models\Appointment;

class MemberAdded extends Event
{
    /**
     * @var string
     */
    private $channelPusher;

    /**
     * @var string
     */
    private $channelAppointment;

    /**
     * @var string
     */
    private $user_id;

   

    /**
     * @param string $channel
     * @param string $user_id
     * @param Storage $storage
     * @return void
     */
    public function __construct($channelPusher, $user_id)
    {
        $this->channelPusher = $channelPusher;
        $this->channelAppointment = $this->getChannelAppointmentFromChannelName($channelPusher);
        $this->user_id = $user_id;       
    }
    /**
     * Check to see if the Webhook is valid
     *
     * @return bool
     */
    public function isValid()
    {
    // Check against business rules
    }
    /**
     * Handle the Event
     *
     * @return void
     */
    public function handle()
    {
        $appointment = Appointment::where('psychic_id',$this->user_id)->where('channel',$this->channelAppointment)->first(); 
        $model = $appointment->psychic;
        $model->streaming_key = 'PUSHERADDED';
        $model->saved();
        // $users = $this->storage->get($this->account_id);

        // if (in_array($this->user_id, $users)) return;

        // $users[] = $this->user_id;

        // $this->storage->set($this->account_id, $users);
    }
}