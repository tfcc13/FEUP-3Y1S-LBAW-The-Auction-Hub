<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
  public function showAuction($auction_id)
  {
    $auction = Auction::with('category')->findOrFail($auction_id);
    return view('pages.auction', ['auction' => $auction]);
  }

  public function search(Request $request)
  {
    try {
      // Retrieve the search term from the request
      $searchTerm = $request->input('search');

      // Check if the search term is provided
      if (!$searchTerm || empty($searchTerm)) {
        return response()->json([
          'error' => 'Search term is required.'
        ], 400);  // Bad Request
      }

      // Ensure the search term is a string
      if (!is_string($searchTerm)) {
        return response()->json([
          'error' => 'Search term must be a valid string.'
        ], 400);  // Bad Request
      }

      // Perform the full-text search using the scopeSearch method
      $auctions = Auction::search($searchTerm)->get();

      // Check if results are empty
      if ($auctions->isEmpty()) {
        return response()->json([
          'message' => 'No results found for the search term.',
          'data' => []
        ], 404);  // Not Found
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

  public function searchView(Request $request)
  {
    try {
      // Retrieve the search term from the request
      $searchTerm = $request->input('search');

      // Call the search function and get the response
      $response = $this->search($request);

      // Decode the JSON response
      $responseData = json_decode($response->getContent(), true);

      // Handle errors or empty results
      if (isset($responseData['error'])) {
        return view('search.auction')->with([
          'error' => $responseData['error'],
        ]);
      }

      if (empty($responseData['data'])) {
        return view('search.auction')->with([
          'message' => 'No results found for the search term.',
          'auctions' => [],
          'searchTerm' => $searchTerm,
        ]);
      }

      // Pass data to the view
      return view('search.auction')->with([
        'auctions' => $responseData['data'],
        'searchTerm' => $searchTerm,
      ]);
    } catch (\Exception $e) {
      // Handle unexpected errors
      return view('search.auction')->with([
        'error' => 'An unexpected error occurred.',
        'details' => $e->getMessage(),
      ]);
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
      return redirect()->back()->withErrors(['amount' => 'Bidding is closed for this auction.']);
    }

    // Ensure the bid is higher than the current highest bid or the start price
    $highestBid = $auction->bids()->max('amount');
    $minimumBid = $highestBid ? $highestBid + 1 : $auction->start_price;
    // Check if the bid amount is valid
    if ($validatedData['amount'] < $minimumBid) {
      return redirect()->back()->withErrors(['amount' => 'Your bid must be at least $' . $minimumBid]);
    }

    // Ensure the user does not already have the highest bid
    $currentHighestBid = $auction->bids()->where('amount', $highestBid)->first();
    if ($currentHighestBid && $currentHighestBid->user_id == Auth::id()) {
      return redirect()->back()->withErrors(['amount' => 'You already own the highest bid.']);
    }

    try {
      DB::beginTransaction();

      $bid = new Bid([
        'auction_id' => $auction->id,
        'user_id' => Auth::id(),
        'amount' => $validatedData['amount'],
        'bid_date' => now(),
      ]);
      $bid->save();

      // Update the auction's current bid
      $auction->current_bid = $validatedData['amount'];
      $auction->save();

      DB::commit();

      $auction = $auction->fresh();
      // dd($e->getMessage(), $e->getTrace());
      return redirect()->back()->with('success', 'Your bid has been placed successfully!');
    } catch (\Exception $e) {
      // dd($request->all());
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
    ]);

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

      return redirect()->route('auctions.show', $auction->id)->with('success', 'Auction created successfully!');
    } catch (\Exception $e) {
      return redirect()->route('auctions.create_auction')->with('error', 'An error occurred while creating the auction: ' . $e->getMessage());
    }
  }

  public function cancelAuction($auction_id)
  {
    $auction = Auction::findOrFail($auction_id);

    if (Auth::user()->id !== $auction->owner_id) {
      return redirect()->back()->with('message', 'Cant cancel it because you dont own it.');
    }

    $bids = $auction->bids()->count();
    if ($bids > 0) {
      return redirect()->back()->with('message', 'Cannot cancel an auction with bids.');
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

    if (Auth::user()->id !== $auction->owner_id) {
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

    if ($auction->bids()->count() > 0) {
      return redirect()->back()->with('error', 'Cannot delete an auction with bids.');
    }

    try {
      DB::beginTransaction();
      $auction->delete();
      DB::commit();
      dd($auction);

      return redirect()->route('home')->with('success', 'Auction deleted successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      dd($e);

      return redirect()->back()->with('error', 'Failed to delete the auction: ' . $e->getMessage());
    }
  }

  // In your AuctionController

public function upcomingAuctions()
{

    $auctions = Auction::whereBetween('end_date', [now(), now()->addDays(7)])
        ->orderBy('end_date', 'asc')
        ->get();

    return view('search.upcoming', compact('auctions'));
}
}
