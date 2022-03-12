<?php
namespace App\Services\Pusher;
abstract class Event
{
    /**
     * Check to see if the Webhook is valid
     *
     * @return bool
     */
    abstract public function isValid();

    /**
     * Handle the Event
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Get the UUID from the channel name
     *
     * @param string $channel
     * @return string
     */
    protected function getChannelAppointmentFromChannelName($channelPusher)
    {
        $position = strpos($channelPusher, ".");
        return substr($channelPusher, $position + 1);
    }
}