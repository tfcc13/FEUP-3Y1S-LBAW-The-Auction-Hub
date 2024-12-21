<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionWin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction_id;

    public $user_id;
    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct($auction, $bid)
    {
        $this ->auction_id = $auction->id;
        $this ->user_id = $bid->user_id;
        $this -> message =  "You've won " . $auction->title;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['the-auction-hub'];
    }


    public function broadcastAs() {
        return 'notification-auction-win-'.$this->user_id;
    }
}
