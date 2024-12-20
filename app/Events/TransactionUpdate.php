<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\MoneyManager;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class TransactionUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $amount;
    public $message;
    public $transaction_id;

    public $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct($transaction)
    {
        
        $this -> amount=$transaction->amount;
        $this -> transaction_id=$transaction->id;
        $this -> user_id=$transaction->user_id;
        $this -> message =  "Your {$transaction->type} of {$transaction->amount}$ with ID {$transaction->id} has been {$transaction->state}.";
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

    public function broadcastAs() {;

        Log::error('Propagatin event notification');
        return 'notification-transaction-state-'.$this->user_id;
    }
}
