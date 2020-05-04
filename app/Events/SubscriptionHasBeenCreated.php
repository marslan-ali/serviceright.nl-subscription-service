<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;
class SubscriptionHasBeenCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $subscription;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subscription)
    {
     $this->subscription = $subscription;
     Log::info("Created a new one");
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
