<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuctionPolicy 
{
    public function update(User $user, Auction $auction)
    {
        return $user->id === $auction->owner_id;
    }
}


