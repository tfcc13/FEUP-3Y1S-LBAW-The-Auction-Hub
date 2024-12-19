<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuctionEnded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction_id;
    public $message;
    public function __construct($auction)
    {
        $this ->auction_id = $auction->id;
        $this -> message =  $auction->title . 'Has ended!';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return ['the-auction-hub'];
    }

    public function broadcastAs() {
        Log::info('Auction ended in auction id', ['auction' => $this->auction_id]);
        return 'notification-auction-ended-'.$this->auction_id;
    }
}
