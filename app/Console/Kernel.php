<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Auction;
use Illuminate\Support\Facades\DB;

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
                Auction::where('id', $id)->update(['state' => 'Resumed']);
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
