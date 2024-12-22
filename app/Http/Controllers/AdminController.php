<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Category;
use App\Models\MoneyManager;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        $reports = Report::all();
        return view('pages.admin.dashboard.notification', compact('reports'));
    }

    public function dashboardUsers($request = null)
    {
        if ($request === null || !$request->has('search')) {
            $users = User::where('state', '!=', 'Deleted')->paginate(8);  // Call paginate first
        } else {
            // If a search term is provided, use the search method to get users
            $response = $this->search($request);

            if ($response->getStatusCode() === 200) {
                $decodedResponse = json_decode($response->getContent(), true);

                // Check if 'data' is present and is an array
                if (isset($decodedResponse['data']) && is_array($decodedResponse['data'])) {
                    $userIds = [];
                    foreach ($decodedResponse['data'] as $userData) {
                        $userIds[] = $userData['id'];  // Add the user ID to the list
                    }

                    // Fetch the users that match the IDs from the database and exclude 'Deleted' users
                    $users = User::whereIn('id', $userIds)->paginate(8);  // Call paginate here
                } else {
                    // If no results from search, fetch all users where state != 'Deleted'
                    $users = User::where('state', '!=', 'Deleted')->paginate(8);
                }
            } else {
                // If the search response is not OK, return an empty collection
                $users = User::where('state', '!=', 'Deleted')->paginate(8);
            }
        }

        // Get the report count for each owner as an associative array
        $reportsPerOwner = Report::join('auction', 'report.auction_id', '=', 'auction.id')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select('auction.owner_id', DB::raw('COUNT(*) as report_count'))
            ->groupBy('auction.owner_id')
            ->orderBy('report_count', 'DESC')
            ->pluck('report_count', 'owner_id');  // Creates key-value pairs: owner_id => report_count

        // Attach report counts to users after pagination
        $users->getCollection()->transform(function ($user) use ($reportsPerOwner) {
            $user->report_count = $reportsPerOwner[$user->id] ?? 0;
            return $user;
        });

        // Return the users with pagination
        return view('pages.admin.dashboard.users', compact('users'));
    }

    public function dashboardAuctions($request = null)
    {
        if ($request == null) {
            $auctions = Auction::paginate(8);
        } else {
            $response = app(AuctionController::class)->search($request);
            if ($response) {
                $decodedResponse = json_decode($response->getContent(), true);

                if (isset($decodedResponse['data']) && is_array($decodedResponse['data'])) {
                    $auctionIds = [];
                    foreach ($decodedResponse['data'] as $auctionData) {
                        $auctionIds[] = $auctionData['id'];
                    }

                    $auctions = Auction::whereIn('id', $auctionIds)->paginate(8);
                } else {
                    $auctions = Auction::paginate(8);
                }
            } else {
                $auctions = Auction::paginate(8);
            }
        }

        $reportsPerAuction = Report::join('auction', 'report.auction_id', '=', 'auction.id')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select(
                'auction.id as auction_id',
                DB::raw('COUNT(*) as report_count')
            )
            ->groupBy('auction.id')
            ->orderBy('report_count', 'DESC')
            ->pluck('report_count', 'auction_id');  // Creates a key-value map

        $auctions->getCollection()->map(function ($auction) use ($reportsPerAuction) {
            $auction->report_count = $reportsPerAuction[$auction->id] ?? 0;
            return $auction;
        });

        // Create a map of users with their IDs as keys
        $users = User::all()->keyBy('id');

        // Add owner information to each auction
        $auctions->getCollection()->map(function ($auction) use ($users) {
            $user = $users[$auction->owner_id] ?? null;

            $auction->owner_username = $user->username ?? 'Unknown';
            $auction->owner_name = $user->name ?? 'Unknown';

            return $auction;
        });

        return view('pages.admin.dashboard.auctions', compact('auctions'));
    }

    public function dashboardCategorie()
    {
        $categories = Category::all();
        return view('pages.admin.dashboard.categories', compact('categories'));
    }

    public function banUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {
            DB::beginTransaction();
            $hasActiveAuctions = Auction::where('owner_id', $user->id)
                ->where('state', 'Ongoing')
                ->exists();

            if ($hasActiveAuctions) {
                // Get all ongoing auctions where the user is the owner
                $auctions = Auction::where('owner_id', $user->id)
                    ->where('state', 'Ongoing')
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

                        // Delete the auction
                        $auction->delete();
                    }
                }
            }

            $auctionIds = $user
                ->ownsBids()
                ->pluck('auction_id')  // Bids made by the user
                ->merge($user->followsAuction()->pluck('auction_id'))  // Auctions followed by the user
                ->merge($user->ownAuctions()->pluck('id'))  // Auctions owned by the user
                ->unique();  // Ensure no duplicate IDs

            // Get all auctions with active bids the user is involved in
            $auctions = Auction::where('state', 'Ongoing')
                ->whereIn('id', $auctionIds)
                ->get();

            foreach ($auctions as $auction) {
                // Find the top bid for the ongoing auction
                $topBid = Bid::where('auction_id', $auction->id)
                    ->orderByDesc('amount')  // Order bids by the highest amount
                    ->first();  // Get the highest bid

                if ($topBid && $topBid->user_id == $user->id) {
                    // Reset the auction to its starting price
                    $auction->current_bid = $auction->start_price;

                    // Refund the user's credits
                    $user->credit_balance += $topBid->amount;

                    // Delete all bids for this auction
                    Bid::where('auction_id', $auction->id)->delete();

                    // Save the auction changes
                    $auction->save();
                }
            }
            $user->ownsBids()->delete();
            $user->state = 'Banned';
            $user->save();
            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to ban the user. Please try again.' . $e);
        }
    }

    public function unbanUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {
            DB::beginTransaction();
            $user->state = 'Active';
            $user->save();
            DB::commit();

            // dd($user->state);

            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            //dd($e);

            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete the user. Please try again.');
        }
    }

    public function promoteUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {
            DB::beginTransaction();
            $user->is_admin = true;
            $user->save();
            DB::commit();
            // dd($user->state);

            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete the user. Please try again.');
        }
    }

    public function search(Request $request)
    {
        try {
            $searchTerm = $request->input('search');

            $users = User::search($searchTerm)->where('state', '!=', 'Deleted')->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No results found for the search term.',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'message' => 'Search successful.',
                'data' => $users
            ], 200);  // OK
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function createCategory(Request $request)
    {
        $text = $request->input('text');
        try {
            $c = Category::create([
                'name' => $text ? $text : 'New Category',
            ]);
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23505') {
                return redirect()->back()->with('error', 'There allready exists a category with this name.');
            }
            // Handle other database errors
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found.');
        }

        try {
            DB::beginTransaction();

            $auction = Auction::where('category_id', $category->id)->first();

            if ($auction) {
                DB::rollBack();

                return redirect()->back()->with('error', 'This category cannot be deleted because there are associated auctions.');
            }
            $category->delete();

            DB::commit();
            return redirect()->route('admin.dashboard')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete the Category. Please try again.');
        }
    }

    public function showTransactions()
    {
        $transactions = MoneyManager::all()->sortByDesc('operation_date');
        return view('pages.admin.dashboard.transactions', compact('transactions'));
    }

    public function statistics()
    {
        // Count active and deleted users
        $users = User::where('state', 'Active')->where('is_admin', false)->count();
        $deletedUsers = User::where('state', 'Deleted')->count();
        $bannedUsers = User::where('state', 'Banned')->count();
        // $totalUsers = $activeUsers + $bannedUsers + $deletedUsers;
        $usersDoughnut = Chartjs::build()
            ->name('UserStateChart')  // Unique chart name
            ->type('doughnut')  // Use 'doughnut' for a round chart
            ->size(['width' => 400, 'height' => 400])  // Adjust chart size
            ->labels(['Active Users', 'Deleted Users', 'Banned Users'])  // Chart labels
            ->datasets([
                [
                    'label' => 'Users',
                    'backgroundColor' => ['#135d3b', '#BDBDBD', '#fc0335'],  // Colors: Green for active, Gray for deleted
                    'data' => [$users, $deletedUsers, $bannedUsers],  // Data: active and deleted user counts
                ]
            ])
            ->options([
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'User Distribution'  // Chart title
                    ],
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom'  // Position of the legend
                    ]
                ]
            ]);

        $months = [];
        $activeUserCounts = [];
        $activeUserCounts2 = [];

        for ($i = 6; $i >= 0; $i--) {
            $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            $activeUserCount = User::where('users.state', 'Active')
                ->leftJoin('bid', 'users.id', '=', 'bid.user_id')
                ->whereBetween('bid_date', [$startOfMonth, $endOfMonth])
                ->Join('auction', 'bid.auction_id', '=', 'auction.id')
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->distinct()
                ->count();
            // Store the month name (e.g., "January") and the count
            $months[] = $startOfMonth->format('F');
            $activeUserCounts[] = $activeUserCount;
        }

        for ($i = 6; $i >= 0; $i--) {
            $startOfMonth = Carbon::now()->subYear()->subMonths($i)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            // Count active users created in this month
            $activeUserCount = User::where('users.state', 'Active')
                ->leftJoin('bid', 'users.id', '=', 'bid.user_id')
                ->whereBetween('bid_date', [$startOfMonth, $endOfMonth])
                ->Join('auction', 'bid.auction_id', '=', 'auction.id')
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->distinct()
                ->count();

            $activeUserCounts2[] = $activeUserCount;
        }
        $activeUsersLineChart = Chartjs::build()
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($months)  // Set the dynamic labels (months)
            ->datasets([
                [
                    'label' => 'Active Users this Year',
                    'backgroundColor' => '#135d3b',
                    'borderColor' => '#135d3b',
                    'pointBorderColor' => '#135d3b',
                    'pointBackgroundColor' => '#135d3b',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                    'data' => $activeUserCounts,  // Active users for each month
                    'fill' => false,
                ],
                [
                    'label' => 'Active Users last Year',
                    'backgroundColor' => 'rgba(38, 185, 154, 0.31)',
                    'borderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBorderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                    'data' => $activeUserCounts2,  // Active users for each month
                    'fill' => false,
                ]
            ])
            ->options([
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Active Users by Month'
                    ],
                ]
            ]);

        $ageGroups = [
            '18-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '56+' => 0
        ];

        // Get the current date
        $now = Carbon::now();

        // Loop through users and categorize them by age
        $users = User::where('state', 'Active')->get();

        foreach ($users as $user) {
            $age = $now->diffInYears(Carbon::parse($user->birth_date));

            // Increment the appropriate age group count
            if ($age >= 18 && $age <= 25) {
                $ageGroups['18-25']++;
            } elseif ($age >= 26 && $age <= 35) {
                $ageGroups['26-35']++;
            } elseif ($age >= 36 && $age <= 45) {
                $ageGroups['36-45']++;
            } elseif ($age >= 46 && $age <= 55) {
                $ageGroups['46-55']++;
            } else {
                $ageGroups['56+']++;
            }
        }

        // Prepare chart data
        $labels = array_keys($ageGroups);  // Age group labels
        $data = array_values($ageGroups);  // Number of users in each age group

        // Build the chart
        $demographicsChart = Chartjs::build()
            ->name('AgeGroupDistribution')
            ->type('bar')
            ->size(['width' => 800, 'height' => 400])
            ->labels($labels)
            ->datasets([
                [
                    'label' => 'Users by Age Group',
                    'backgroundColor' => '#135d3b',
                    'data' => $data,
                ]
            ])
            ->options([
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'stepSize' => 1
                        ],
                    ],
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'User Age Group Distribution'
                    ],
                ]
            ]);

        $monthsThisYear = [];
        $bidsThisYear = [];
        $bidsLastYear = [];

        for ($i = 6; $i >= 0; $i--) {
            // Get the start and end of the current month for this year
            $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            // Get the bid count for this month
            $bid = Bid::whereBetween('bid_date', [$startOfMonth, $endOfMonth])->count();

            // Store the current month and bid count for this year
            $monthsThisYear[] = $startOfMonth->format('F');
            $bidsThisYear[] = $bid;
        }

        for ($i = 6; $i >= 0; $i--) {
            // Get the start and end of the current month for last year
            $startOfMonth = Carbon::now()->subYear()->subMonths($i)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            // Get the bid count for this month
            $bid = Bid::whereBetween('bid_date', [$startOfMonth, $endOfMonth])->count();

            $bidsLastYear[] = $bid;
        }

        // Combine both months for the chart labels
        $bids = array_merge($bidsThisYear, $bidsLastYear);

        $bidsByMonth = Chartjs::build()
            ->name('lineBids')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($monthsThisYear)  // Set the dynamic labels (months)
            ->datasets([
                [
                    'label' => 'Bids this Year',
                    'backgroundColor' => '#135d3b',
                    'borderColor' => '#135d3b',
                    'pointBorderColor' => '#135d3b',
                    'pointBackgroundColor' => '#135d3b',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => '#135d3b',
                    'data' => $bidsThisYear,  // Active users for each month this year
                    'fill' => false,
                ],
                [
                    'label' => 'Bids last Year',
                    'backgroundColor' => 'rgba(38, 185, 154, 0.31)',
                    'borderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBorderColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                    'data' => $bidsLastYear,  // Active users for each month last year
                    'fill' => false,
                ]
            ])
            ->options([
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Bids by Month (This Year vs Last Year)'
                    ],
                ]
            ]);

        $auctions = Auction::where('state', 'Ongoing')->count();
        $closedAuctions = Auction::where('state', 'Closed')->count();
        $canceledAuctions = Auction::where('state', 'Canceled')->count();
        $auctionsDoughnut = Chartjs::build()
            ->name('AuctionStateChart')  // Unique chart name
            ->type('doughnut')  // Use 'doughnut' for a round chart
            ->size(['width' => 400, 'height' => 400])  // Adjust chart size
            ->labels(['Ongoing auctions', 'Closed Auctions', 'Canceled Auctions'])  // Chart labels
            ->datasets([
                [
                    'label' => 'Auctions',
                    'backgroundColor' => ['#135d3b', '#BDBDBD', '#fc0335'],  // Colors: Green for active, Gray for deleted
                    'data' => [$auctions, $closedAuctions, $canceledAuctions],  // Data: active and deleted user counts
                ]
            ])
            ->options([
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Auctions Distribuition'  // Chart title
                    ],
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom'  // Position of the legend
                    ]
                ]
            ]);

        // Get the number of bids per category
        $categoryBids = Bid::join('auction', 'bid.auction_id', '=', 'auction.id')
            ->join('category', 'auction.category_id', '=', 'category.id')  // Assuming 'categories' table exists
            ->select('category.name as category', DB::raw('COUNT(bid.id) as bid_count'))  // Getting category name and bid count
            ->groupBy('auction.category_id', 'category.name')  // Group by category_id and category name
            ->orderByDesc('bid_count')  // Optional: Order by highest bid count
            ->get();

        $categories = [];
        $bidCounts = [];

        // Loop through the data and extract categories and bid counts
        foreach ($categoryBids as $categoryBid) {
            $categories[] = $categoryBid->category;  // Get the category name
            $bidCounts[] = $categoryBid->bid_count;  // Get the bid count
        }

        // Prepare the chart data
        $categoryBidsChart = Chartjs::build()
            ->name('categoryBidsChart')
            ->type('bar')
            ->size(['width' => 600, 'height' => 400])
            ->labels($categories)  // X-axis labels (categories)
            ->datasets([
                [
                    'label' => 'Bids per Category',
                    'backgroundColor' => '#135d3b',  // Bar color
                    'data' => $bidCounts,  // Y-axis data (bid counts)
                ]
            ])
            ->options([
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,  // Start Y-axis at zero
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Bids by Category',  // Chart title
                    ],
                    'legend' => [
                        'display' => false,  // Optional: Hide the legend if not needed
                    ],
                ],
            ]);

        return view('pages.admin.dashboard.statistics', compact(
            'usersDoughnut',
            'auctionsDoughnut',
            'activeUsersLineChart',
            'bidsByMonth',
            'categoryBidsChart',
            'demographicsChart'
        ));
    }
}
