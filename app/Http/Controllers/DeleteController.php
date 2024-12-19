<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class DeleteController extends Controller
{
    public function deleteUser($userId)
    {
        $user = User::find($userId);
        // Authorize based on the policy
        $this->authorize('delete', $user);

        // Perform necessary checks before deletion
        $hasActiveAuctions = Bid::join('auction', 'bid.auction_id', '=', 'auction.id')
            ->where('auction.owner_id', $user->id)
            ->where('auction.state', 'Ongoing')
            ->exists();
        DB::beginTransaction();

        try {
            if ($hasActiveAuctions) {
                // Get all ongoing auctions where the user is the owner
                $auctions = Auction::where('owner_id', $user->id)
                    ->where('state', 'Ongoing')  // Filter for ongoing auctions
                    ->get();

                // Check if the user has active auctions
                if ($auctions->isNotEmpty()) {
                    foreach ($auctions as $auction) {
                        // Find the top bid for the ongoing auction
                        $topBid = Bid::where('auction_id', $auction->id)
                            ->orderByDesc('amount')  // Order bids by the highest amount
                            ->first();  // Get the highest bid

                        // If there is a top bid, add money to the top bidder's balance
                        if ($topBid) {
                            // Get the user who placed the top bid
                            $topBidder = $topBid->user;

                            // Add the amount of the top bid to the bidder's balance
                            $topBidder->credit_balance += $topBid->amount;  // Assuming `amount` is the bid value
                            $topBidder->save();
                        }
                        $auction->delete();
                    }
                }
            }

            if ($user->credit_balance > 0) {
                return redirect()->back()->with('error', 'Cannot delete account with money remaining.');
            }
            if ($user->activeBids()) {
                return redirect()->back()->with('error', 'Cannot delete account In account with bids.');
            }

            $user->name = 'anonymous';
            $user->username = 'anonymous';
            $user->email = 'anonymous';
            $user->state = 'Deleted';
            $user->save();
            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Unexpected Error.' . $e);
        }
    }

    // Delete auction
    public function deleteAuction(Auction $auction)
    {
        // Ensure only the owner or admin can delete the auction
        $this->authorize('delete', $auction);

        // Ensure no active bids on the auction
        if ($auction->bids()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete auction with active bids.');
        }

        // Delete the auction
        $auction->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Auction deleted successfully.');
    }
}
