<?php

namespace Imrancse94\Grocery\app\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Imrancse94\Grocery\app\Models\PreOrder;

class PreOrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $preOrder;

    /**
     * Create a new event instance.
     */
    public function __construct($preOrder)
    {
        $this->preOrder = $preOrder;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
