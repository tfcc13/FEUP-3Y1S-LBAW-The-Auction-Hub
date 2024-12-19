<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AuctionBid implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bid;
    public $auction_id;
    public $message;
    public function __construct($bid, $auction)
    {
        $this ->bid = $bid;
        $this ->auction_id = $auction->id;
        $this -> message = 'Someone has bidded ' . $auction->title . '!';
        Log::info('BidPlaced event triggered', ['bid' => $bid]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        Log::info('Broadcasting on auction-channel');
        return ['the-auction-hub'];
    }

    public function broadcastAs() {
        return 'notification-bid';
    }

}
