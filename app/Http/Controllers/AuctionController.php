<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\AuctionBid;


class AuctionController extends Controller
{
  public function showAuction($auction_id)
  {
    $auction = Auction::with('category')->findOrFail($auction_id);
    return view('pages.auction', ['auction' => $auction]);
  }

  public function showCategory($id)
  {
    $categories = $this->getCategories();
    $auctions = Auction::with('images')
      ->where('category_id', $id)
      ->where('state', 'Ongoing')
      ->get()
      ->map(function ($auction) {
        $auction->primaryImage = $auction->primaryImage();
        return $auction;
      });
    $name = Category::find($id)->name;
    if ($auctions->isEmpty()) {
      return view('layouts.category', ['name' => $name, 'auctions' => $auctions, 'categories' => $categories])->with('error', 'No Auction in this category');
    }
    return view('layouts.category', ['name' => $name, 'auctions' => $auctions, 'categories' => $categories]);
  }

  public function search(Request $request)
  {
    try {
      // Retrieve the search term from the request
      $searchTerm = $request->input('search');
      $categories = $request->get('category', []);

      $query = Auction::with('images')->search($searchTerm);

      if (!empty($categories)) {
        $query->whereIn('category_id', $categories);
      }
      $query->where('end_date', '>', now());

      $auctions = $query->get();

      $auctions = $auctions->map(function ($auction) {
        $auction->primaryImage = $auction->primaryImage();
        return $auction;
      });

      if ($auctions->isEmpty()) {
        return response()->json([
          'message' => 'No results found for the search term.',
          'data' => []
        ], 200);  // OK
      }

      // Return the search results as JSON
      return response()->json([
        'message' => 'Search successful.',
        'data' => $auctions
      ], 200);  // OK
    } catch (\Exception $e) {
      // Handle unexpected errors
      return response()->json([
        'error' => 'An unexpected error occurred.',
        'details' => $e->getMessage()
      ], 500);  // Internal Server Error
    }
  }

  public function bidAuction(Request $request, $id)
  {
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'You must be logged in to place a bid.');
    }

    $validatedData = $request->validate([
      'amount' => 'required|numeric|min:1001',
    ]);

    $auction = Auction::findOrFail($id);

    if ($auction->state !== 'Ongoing') {
      return redirect()->back()->with('error', 'Bidding is closed for this auction.');
    }

    // Ensure the bid is higher than the current highest bid or the start price
    $highestBid = $auction->bids()->max('amount');
    $minimumBid = $highestBid ? $highestBid + 1 : $auction->start_price;
    // Check if the bid amount is valid
    if ($validatedData['amount'] < $minimumBid) {
      return redirect()->back()->with('error', 'Your bid must be at least $' . $minimumBid);
    }

    // Ensure the user does not already have the highest bid
    $currentHighestBid = $auction->bids()->where('amount', $highestBid)->first();
    if ($currentHighestBid && $currentHighestBid->user_id == Auth::id()) {
      return redirect()->back()->with('error', 'You already own the highest bid.');
    }

    $currentUser = Auth::user();
    if ($currentUser->credit_balance < $validatedData['amount']) {
      return redirect()->back()->with('error', 'Insufficient balance to place this bid.');
    }

    try {
      DB::beginTransaction();

      if ($currentHighestBid) {
        $previous_bidder = User::findOrFail($currentHighestBid->user_id);
        if ($previous_bidder) {
          $previous_bidder->credit_balance += $currentHighestBid->amount;
          $previous_bidder->save();
        }
      }

      $bid = new Bid([
        'auction_id' => $auction->id,
        'user_id' => Auth::id(),
        'amount' => $validatedData['amount'],
        'bid_date' => now(),
      ]);
      $bid->save();

      $currentUser->credit_balance -= $validatedData['amount'];
      $currentUser->save();

      // Update the auction's current bid
      $auction->current_bid = $validatedData['amount'];
      $auction->save();

      DB::commit();

      $auction = $auction->fresh();
      // dd($e->getMessage(), $e->getTrace());

      event(new AuctionBid($bid, $auction));
      return redirect()->back()->with('success', 'Your bid has been placed successfully!');
    } catch (\Exception $e) {
      // dd($e->getMessage(), $e->getTrace());
      DB::rollBack();
      return redirect()->back()->with('error', 'An error occurred while placing your bid: ' . $e->getMessage());
    }
  }

  public function createAuction()
  {
    Auth::check();
    $categories = Category::all();
    return view('pages.create_auction', compact('categories'));
  }

  public function submitAuction(Request $request)
  {
    // Validate the form data
    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'start_price' => 'required|numeric|min:0',
      'category_id' => 'required|exists:category,id',
      'files.*' => [
        'required',
        'image',
        'mimes:jpeg,png,jpg,webp',
        'max:2048',  // maximum file size in kilobytes
      ],
    ]);

    // dd($validatedData);

    try {
      DB::beginTransaction();
      // Create a new auction
      $auction = new Auction();
      $auction->title = $validatedData['title'];
      $auction->description = $validatedData['description'];
      $auction->start_price = $validatedData['start_price'];
      $auction->category_id = $validatedData['category_id'];
      $auction->owner_id = Auth::id();
      $auction->save();
      DB::commit();

      if ($request->hasFile('files')) {
        // dd($request);
        // dd($fileRequest, $request);
        app(FileController::class)->uploadAuctionImages($request, $auction->id);
      }

      return redirect()->route('auctions.show', $auction->id)->with('success', 'Auction created successfully!');
    } catch (\Exception $e) {
      return redirect()->route('auctions.create_auction')->with('error', 'An error occurred while creating the auction: ' . $e->getMessage());
    }
  }

  public function cancelAuction($auction_id)
  {
    $auction = Auction::findOrFail($auction_id);

    if (Auth::user()->id !== $auction->owner_id && !Auth::user()->is_admin) {
      return redirect()->back()->with('message', 'Cant cancel it because you dont own it.');
    }

    $bids = $auction->bids()->count();
    if ($bids > 0) {
      return redirect()->back()->with('error', 'Cannot cancel an auction with bids.');
    }

    try {
      DB::beginTransaction();
      $auction->update([
        'state' => 'Canceled',
        'end_date' => now(),
      ]);

      DB::commit();
      return redirect()->back()->with('message', 'Auction canceled successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Database operation failed: ' . $e->getMessage());
    }
  }

  public function editAuction($auction_id)
  {
    $categories = Category::all();
    $auction = Auction::findOrFail($auction_id);

    if (Auth::user()->id !== $auction->owner_id && !Auth::user()->is_admin) {
      return redirect()->back()->with('message', 'You do not have permission to edit this auction.');
    }

    $this->authorize('update', $auction);

    return view('pages.edit_auction', compact('auction', 'categories'));
  }

  public function update(Request $request, $auction_id)
  {
    $auction = Auction::findOrFail($auction_id);

    // are both of them needed ?
    $this->authorize('update', $auction);

    // not neeeded it redirects to a 403 page because of the auction policy
    /*         if (Auth::user()->id !== $auction->owner_id) {
                                                                                                                                        return redirect()->back()->with('message', 'You do not have permission to edit this auction.');
                                                                                                                                    } */

    $validatedData = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'category_id' => 'required|exists:category,id',
    ]);

    try {
      DB::beginTransaction();

      $auction->update($validatedData);

      DB::commit();
      return redirect()->route('auctions.show', $auction->id)->with('success', 'Auction updated successfully!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'An error occurred while updating the auction: ' . $e->getMessage());
    }
  }

  public function deleteAuction($auction_id, Request $request)
  {
    $auction = Auction::findOrFail($auction_id);
    $this->authorize('delete', $auction);

    if ($auction->bids()->count() > 0 && $auction->state === "Ongoing") {
      return redirect()->back()->with('error', 'Cannot delete an ongoing auction with bids.');
    }

    try {
      DB::beginTransaction();
      $auction->delete();
      DB::commit();

      return redirect()->route('home')->with('success', 'Auction deleted successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Failed to delete the auction: ' . $e->getMessage());
    }
  }

  // In your AuctionController

  public function upcomingAuctions()
  {
    $categories = $this->getCategories();

    $auctions = Auction::with('images')
      ->whereBetween('end_date', [now(), now()->addDays(7)])
      ->orderBy('end_date', 'asc')
      ->get()
      ->map(function ($auction) {
        $auction->primaryImage = $auction->primaryImage();
        return $auction;
      });

    return view('search.upcoming', compact('auctions', 'categories'));
  }

  public function getAuctionState($id)
  {
    $auction = Auction::findOrFail($id);
    return response()->json(['state' => $auction->state]);
  }

  public function report(Request $request, $auctionId)
  {
    $userId = Auth::id();
    $text = $request->input('text');

    try {
      Report::create([
        'user_id' => $userId,
        'auction_id' => $auctionId,
        'description' => $text ? $text : 'User requested to ban another user.',
        'state' => 'Pending',
      ]);

      return redirect()->back()->with('success', 'Your report has been submitted.');
    } catch (\Illuminate\Database\QueryException $e) {
      // Check for unique constraint violation (PostgreSQL error code for unique violation is 23505)
      if ($e->getCode() == '23505') {
        return redirect()->back()->with('error', 'You have already reported this auction.');
      }

      return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
    }
  }

  public function toggleFollow(Auction $auction)
  {
    $user = Auth::user();

    if ($user->followsAuction()->where('auction_id', $auction->id)->exists()) {
      $user->followsAuction()->detach($auction->id);
      $message = 'Auction unfollowed successfully.';
    } else {
      $user->followsAuction()->attach($auction->id);
      $message = 'Auction followed successfully.';
    }

    return redirect()->back()->with('success', $message);
  }

  public function relatedAuctions(Request $request)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json([], 200);
    }

    $auctionIds = $user->ownsBids()->pluck('auction_id')
      ->merge($user->followsAuction()->pluck('auction_id'))
      ->merge($user->ownAuctions()->pluck('id'))
      ->unique();

    return response()->json($auctionIds->values());
  }
}
