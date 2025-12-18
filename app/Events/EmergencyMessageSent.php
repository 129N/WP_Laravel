<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmergencyMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $event_code, 
        public int $participant_id, 
        public array $payload
    )
    {}

    public function broadcastOn()
    {
        return [
            new PrivateChannel("emergency.event.{$this->event_code}.participant.{$this->participant_id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'emergency.message';
    }
}
