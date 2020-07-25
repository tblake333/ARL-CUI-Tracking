<?php

namespace App\Events;

use App\Item;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class representing an Item edit event
 * 
 * @author Tristan Blake
 */
class ItemEditedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $item;
    public $user;

    /**
     * Create an instance of ItemEditedEvent.
     *
     * @return void
     */
    public function __construct(Item $item, User $user)
    {
        $this->item = $item;
        $this->user = $user;
    }
}
