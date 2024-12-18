<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Auction;
use App\Models\AuctionWinner;
use App\Models\Bid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $auction_ids = Auction::where('end_date', '<', now())
            ->where('state', 'Ongoing')
            ->pluck('id');

        foreach ($auction_ids as $id) {
            DB::transaction(function () use ($id) {
                Auction::where('id', $id)->update(['state' => 'Closed']);
                
                $auction = Auction::find($id);
                if ($auction) {
                    Log::error("Auction found: ID $id");
                    //return; // Skip if auction is not found
                }
                if(Bid::where('auction_id', $id)->exists()) {
                    
                    $highest_bid = Bid::where('auction_id', $id)->orderBy('amount', 'desc')->first(); 
                    Log::error("Highest bid found: $highest_bid");
                    AuctionWinner::create([
                        'auction_id' => $id,
                        'user_id' => $highest_bid->user_id,
                        'rating' => null,
                    ]);
                    
                    //$auction = Auction::findOrFail($id);
                    $auction_owner = $auction->owner_id; 
                    
                    //dd($auction, $auction_owner);

                    DB::table('users')->where('id', $auction_owner)->increment('credit_balance', $highest_bid->amount);


                }

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
