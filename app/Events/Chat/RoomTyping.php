<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User\User;
use App\Models\Chat\Chatroom;

class RoomTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $room;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Chatroom $room)
    {
        $this->user = $user;
        $this->room = $room;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("marimasak.chatroom.{$this->room->id}");
    }
}
