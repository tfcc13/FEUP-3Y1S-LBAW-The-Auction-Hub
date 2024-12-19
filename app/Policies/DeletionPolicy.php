<?php

namespace App\Policies;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Support\Facades\Log;
class DeletionPolicy
{
    /**
     * Determine if a user can delete a given user account.
     */
    public function deleteUser(User $currentUser, User $accountUser)
    {
        Log::info('Policy deleteUser called', [
            'currentUserId' => $currentUser->id,
            'currentUserIsAdmin' => $currentUser->is_admin,
            'accountUserId' => $accountUser->id,
            'isOwner' => $currentUser->id === $accountUser->id,
        ]);
        if ($currentUser->is_admin || $currentUser->id === $accountUser->id) {
            return true;
        }
        dd($currentUser, $accountUser);

        return false;
    }

    /**
     * Determine if a user can delete an auction.
     */
    public function deleteAuction(User $currentUser, Auction $auction)
    {
        // User must be an admin or the auction owner
        if ($currentUser->is_admin || $currentUser->id === $auction->owner_id) {
            // Ensure the auction has no active bids
            if (!$auction->bids()->exists()) {
                return true;
            }
        }

        return false;
    }
}
