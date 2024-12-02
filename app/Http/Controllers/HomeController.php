<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Auction;
use Exception;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $categories = $this->getCategories();

        try {
            // Get featured auctions - one from each category
            $featuredAuctions = Auction::query()
                ->select('auction.*')
                ->where('auction.state', '!=', Auction::STATE_CANCELED)
                ->with(['category', 'images'])
                ->orderBy('auction.start_date', 'desc')
                ->take(4)
                ->get();

            $carouselItems = $featuredAuctions->map(function ($auction) {
                return [
                    'title' => $auction->title,
                    'description' => $auction->description,
                    'buttonAction' => url('/auctions/auction/' . $auction->id),
                    'imageUrl' => $auction->primaryImage(true)
                ];
            })->toArray();

            Log::info('Featured auctions fetched successfully: ' . $featuredAuctions->count());
            Log::info('Featured auctions: ' . json_encode($featuredAuctions));
            Log::info('Carousel items: ' . json_encode($carouselItems));
        } catch (Exception $e) {
            Log::error('Failed to fetch featured auctions: ' . $e->getMessage());
            $carouselItems = [];
            $featuredAuctions = collect([]);
        }

        try {
            // Get slide items with error prevention
            $featuredAuctionIds = $featuredAuctions->pluck('id');

            $slideItems = Auction::query()
                ->where('state', '!=', Auction::STATE_CANCELED)
                ->whereNotIn('id', $featuredAuctionIds)
                ->with(['images'])
                ->orderBy('start_date', 'desc')
                ->take(20)
                ->get()
                ->map(function ($auction) {
                    return [
                        'title' => $auction->title,
                        'current_bid' => $auction->bids->first()->amount ?? $auction->start_price,
                        'buttonAction' => url('/auctions/auction/' . $auction->id),
                        'imageUrl' => $auction->primaryImage(true)
                    ];
                })->toArray();

            Log::info('Slide items fetched successfully: ' . count($slideItems));
        } catch (Exception $e) {
            Log::error('Failed to fetch slide items: ' . $e->getMessage());
            $slideItems = [];
        }

        return view('home.home', compact('categories', 'carouselItems', 'slideItems'));
    }
}
