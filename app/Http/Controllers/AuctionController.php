<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
public function search(Request $request)
{
    try {
        // Retrieve the search term from the request
        $searchTerm = $request->input('search');

        // Check if the search term is provided
        if (!$searchTerm || empty($searchTerm)) {
            return response()->json([
                'error' => 'Search term is required.'
            ], 400); // Bad Request
        }

        // Ensure the search term is a string
        if (!is_string($searchTerm)) {
            return response()->json([
                'error' => 'Search term must be a valid string.'
            ], 400); // Bad Request
        }

        // Perform the full-text search using the scopeSearch method
        $auctions = Auction::search($searchTerm)->get();

        // Check if results are empty
        if ($auctions->isEmpty()) {
            return response()->json([
                'message' => 'No results found for the search term.',
                'data' => []
            ], 404); // Not Found
        }

        // Return the search results as JSON
        return response()->json([
            'message' => 'Search successful.',
            'data' => $auctions
        ], 200); // OK
    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'error' => 'An unexpected error occurred.',
            'details' => $e->getMessage()
        ], 500); // Internal Server Error
    }
}
}
