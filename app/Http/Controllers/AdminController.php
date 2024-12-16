<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use App\Models\MoneyManager;
use App\Models\Report;
use App\Models\User;
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
        if ($request == null) {
            $users = User::all();
        } else {
            $response = $this->search($request);
            if ($response) {
                $decodedResponse = json_decode($response->getContent(), true);

                // Check if 'data' is present and is an array
                if (isset($decodedResponse['data']) && is_array($decodedResponse['data'])) {
                    $userIds = [];
                    foreach ($decodedResponse['data'] as $userData) {
                        // Add the user ID to the list (you can also add more conditions here if needed)
                        $userIds[] = $userData['id'];
                    }

                    // Fetch the users that match the IDs from the database
                    $users = User::whereIn('id', $userIds)->get();
                } else {
                    $users = User::all();
                }
            } else {
                // If no response or an invalid response, return an empty collection
                $users = collect();
            }
        }

        // Get the report count for each owner as an associative array
        $reportsPerOwner = Report::join('auction', 'report.auction_id', '=', 'auction.id')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select('auction.owner_id', DB::raw('COUNT(*) as report_count'))
            ->groupBy('auction.owner_id')
            ->orderBy('report_count', 'DESC')
            ->pluck('report_count', 'owner_id');  // Creates key-value pairs: owner_id => report_count

        // Attach report counts to users
        $users = $users->map(function ($user) use ($reportsPerOwner) {
            $user->report_count = $reportsPerOwner[$user->id] ?? 0;
            return $user;
        });

        return view('pages.admin.dashboard.users', compact('users'));
    }

    public function dashboardAuctions()
    {
        $reportsPerAuction = Report::join('auction', 'report.auction_id', '=', 'auction.id')
            ->join('users', 'users.id', '=', 'auction.owner_id')
            ->select(
                'auction.id as auction_id',
                'auction.title as title',
                DB::raw('COUNT(*) as report_count'),
                'users.name as owner_name',
                'users.username as owner_username'
            )
            ->groupBy('auction.id', 'auction.title', 'users.name', 'users.username')
            ->orderBy('report_count', 'DESC')
            ->get();
        return view('pages.admin.dashboard.auctions', compact('reportsPerAuction'));
    }

    public function dashboardCategorie()
    {
        $categories = Category::all();
        return view('pages.admin.dashboard.categories', compact('categories'));
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {
            DB::beginTransaction();
            $user->delete();

            DB::commit();
            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            dd($e);

            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete the user. Please try again.');
        }
    }

    public function banUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {
            DB::beginTransaction();
            $user->ownAuction()->delete();  // Assuming the User has created auctions
            $user->ownsBids()->delete();  // Assuming the User has placed bids
            $user->state = 'Banned';
            $user->save();
            DB::commit();

            // dd($user->state);

            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            dd($e);

            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete the user. Please try again.');
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
            dd($e);

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

            if (!$searchTerm || empty($searchTerm)) {
                return response()->json([
                    'error' => 'Search term is required.'
                ], 400);  // Bad Request
            }

            if (!is_string($searchTerm)) {
                return response()->json([
                    'error' => 'Search term must be a valid string.'
                ], 400);  // Bad Request
            }

            $users = User::search($searchTerm)->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No results found for the search term.',
                    'data' => []
                ], 200);  // OK
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
}
