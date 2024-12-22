<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MoneyManager;
use App\Models\UserImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function updateDescription(Request $request)
  {
    $request->validate([
      'description' => 'nullable|string|max:255',  // Adjust validation rules as needed
    ]);

    $user = auth()->user();
    $user->description = $request->input('description');
    $user->save();

    return redirect()->back()->with('success', 'Description updated successfully!');
  }

  public function showProfile($username = null)
  {
    try {
      $user = $username
        ? User::where('username', $username)->firstOrFail()
        : auth()->user();

      $isOwner = auth()->check() && auth()->user()->id === $user->id;

      return view('pages.user.profile', [
        'user' => $user,
        'isOwner' => $isOwner,
      ]);
    } catch (ModelNotFoundException $e) {
      // Handle the exception (e.g., redirect to a 404 page or display an error)
      abort(404, 'User not found.');
    }
  }

  public function addMoney(Request $request)
  {
    // Validate the input
    $request->validate([
      'amount' => 'required|numeric|min:1',  // Ensure the amount is numeric and greater than zero
    ]);

    $user = auth()->user();  // Get the currently logged-in user
    $amount = $request->input('amount');

    try {
      $user->addMoney($amount);
      return response()->json(['message' => 'Money added successfully!', 'balance' => $user->credit_balance], 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function search(Request $request)
  {
    try {
      // Retrieve the search term from the request
      $searchTerm = $request->input('search');

      $users = User::search($searchTerm)->where('state', '!=', 'Banned')->get();

      // Check if results are empty
      if ($users->isEmpty()) {
        return response()->json([
          'message' => 'No results found for the search term.',
          'data' => []
        ], 200);  // OK
      }

      // Return the search results as JSON
      return response()->json([
        'message' => 'Search successful.',
        'data' => $users
      ], 200);  // OK
    } catch (\Exception $e) {
      // Handle unexpected errors
      return response()->json([
        'error' => 'An unexpected error occurred.',
        'details' => $e->getMessage()
      ], 500);  // Internal Server Error
    }
  }

  public function showUserAuctions()
  {
    $user = auth()->user();
    $auctions = $user->ownAuctions()->get();
    return view('pages.user.dashboard.auctions', ['auctions' => $auctions]);
  }

  public function showStatistics()
  {
    $user = auth()->user();
    $auctionWonCount = $user->auctionWon->count();
    $totalAuctionsWonValue = $user->auctionWon->sum('current_bid');
    $maxAuctionWonValue = $user->auctionWon->max('current_bid');
    $avgAuctionWonValue = $user->auctionWon->avg('current_bid');

    $totalBidsMade = $user->ownsBids->count();
    $totalAmountSpentOnBids = $user->ownsBids->sum('amount');
    $avgBidAmount = $user->ownsBids->avg('amount');
    $bidSuccessRate = $totalBidsMade > 0 ? round(($user->auctionWon->count() / $totalBidsMade) * 100, 2) : 0;

    $totalAuctionsParticipatedIn = $totalBidsMade;
    $mostActiveCategory = $user->ownsBids->groupBy('auction.category_id')->keys()->first();

    // Pass data to the view
    return view('pages.user.dashboard.auctionStats', compact(
      'auctionWonCount',
      'totalAuctionsWonValue',
      'maxAuctionWonValue',
      'avgAuctionWonValue',
      'totalBidsMade',
      'totalAmountSpentOnBids',
      'avgBidAmount',
      'bidSuccessRate',
      'totalAuctionsParticipatedIn',
      'mostActiveCategory'
    ));
  }

  public function showFinancial()
  {
    $user = auth()->user();
    $transactions = $user->allTransactions()
        ->orderBy('operation_date', 'desc')
        ->limit(10)
        ->get();
    $balance = $user->credit_balance;

    return view('pages.user.dashboard.financial', compact('balance','transactions'));
  }

  public function getTransactions() {
    $user = auth()->user();
    $transactions = $user->allTransactions()
        ->orderBy('operation_date', 'desc')
        ->limit(10)
        ->get();

    return response()->json($transactions);
  }

  public function showBids()
  {
    $user = auth()->user();
    $bidsMade = $user->ownsBids;
    return view('pages.user.dashboard.bids', compact('bidsMade'));
  }

  public function followedAuctions()
  {
    $user = auth()->user();
    $followed = $user->followsAuction;  // Changed from follows to followsAuction
    return view('pages.auctions.follow', compact('followed'));
  }

  public function updateProfilePicture(Request $request)
{
   
    $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    $user = Auth::user();
    
    if ($request->hasFile('file')) {
      
   
        app(FileController::class)->uploadUserImage($request, $user->id);

        return back()->with('success', 'Profile picture updated successfully.');
    }

    

    return back()->with('error', 'Please select a valid image file.');
}



}
