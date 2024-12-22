<?php

namespace App\Console;

use App\Events\AuctionWin;
use App\Http\Controllers\AuctionController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Auction;
use App\Models\User;
use App\Models\AuctionWinner;
use App\Models\Bid;
use App\Models\MoneyManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\AuctionEnded;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
/*         $schedule->call(function() {
            try {
                $updatedCount = Auction::where('end_date', '<', now())
                ->where('state', 'Ongoing')
                ->update(['state' => 'Resumed']);
                Log::info("Auction state update completed. Rows affected: {$updatedCount}");
            } catch(\Exception $e) {
                Log::error("Error updating auction state: {$e->getMessage()}");
            }
        })->everyMinute();
    } */

    $schedule->call(function () {
        $auction_ids = Auction::where('end_date', '<=', now())
            ->where('state', 'Ongoing')
            ->pluck('id');

        foreach ($auction_ids as $id) { 
            DB::transaction(function () use ($id) {
                Auction::where('id', $id)->update(['state' => 'Closed']);

                $auction = Auction::find($id);


                if(Bid::where('auction_id', $id)->exists()) {
                    
                    $highest_bid = Bid::where('auction_id', $id)->orderBy('amount', 'desc')->first(); 
                    Log::error("Highest bid found: $highest_bid");
                    AuctionWinner::create([
                        'auction_id' => $id,
                        'user_id' => $highest_bid->user_id,
                        'rating' => null,
                    ]);
                    
                    //$auction = Auction::findOrFail($id);
                    $auction_owner = User::findOrFail($auction->owner_id); 
                    $winner = User::findOrFail($highest_bid->user_id);

                    $winner->notifications()->create([
                        'content' => "You have won auction {$auction->title} and paid {$highest_bid->amount}$.",
                        'type' => 'AuctionUpdate',
                        'user_id' => $winner->id,
                        'auction_id' => $auction->id,
                        'view_status' => false,
                    ]);

                    $auction_owner->notifications()->create([
                        'content' => "You have received {$highest_bid->amount}$ from {$winner->username} on {$auction->title}.",
                        'type' => 'AuctionUpdate',
                        'user_id' => $auction_owner->id,
                        'auction_id' => $auction->id,
                        'view_status' => false,
                    ]);

                    MoneyManager::create([
                        'amount' => $highest_bid->amount,
                        'user_id' => $highest_bid->user_id,
                        'state' => 'Approved',
                        'recipient_user_id' => $auction_owner->id,
                        'type' => 'Transaction',
                    ]);
                    
                    DB::table('users')->where('id', $auction_owner->id)->increment('credit_balance', $highest_bid->amount);
                    event(new AuctionWin($auction, $highest_bid));
                }
                event(new AuctionEnded( $auction));
            });
        }
    })->everyMinute();    
}

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
