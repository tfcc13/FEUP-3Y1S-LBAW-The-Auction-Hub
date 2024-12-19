<?php

namespace App\Policies;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class AuctionPolicy
{
  public function update(User $user, Auction $auction)
  {
    return ($user->id === $auction->owner_id || $user->is_admin);
  }

  public function delete(User $user, Auction $auction)
  {
    return ($user->id === $auction->owner_id || $user->is_admin);
  }
}
