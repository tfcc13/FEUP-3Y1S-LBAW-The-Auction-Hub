<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Auction;

class AuctionChannel 
{

    public function join(User $user, $auctionId)
    {
        
        $auction = Auction::find($auctionId);

        $auction = Auction::find($auctionId);
        return $auction && ($auction->followers()->where('user_id', $user->id)->exists() ||
                        $auction->bids()->where('user_id', $user->id)->exists());
    }
}

