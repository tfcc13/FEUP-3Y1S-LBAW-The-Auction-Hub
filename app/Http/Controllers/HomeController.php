<?php

namespace App\Http\Controllers;

// use App\Models\Category;
// use App\Models\Auction;

use Illuminate\Database\Eloquent\Collection;
use stdClass;

class HomeController extends Controller
{
    public function index()
    {
        $categories = collect([
            $this->createMockCategory('Watches'),
            $this->createMockCategory('Vehicles'),
            $this->createMockCategory('Jewelry'),
            $this->createMockCategory('Collectibles'),
            $this->createMockCategory('Sports Memorabilia'),
            $this->createMockCategory('Art'),
            $this->createMockCategory('Antiques'),
            $this->createMockCategory('Coins & Paper Money'),
            $this->createMockCategory('Electronics')
        ]);

        // Database implementation for later:
        /*
        $featuredAuctions = Auction::where('state', '!=', 'canceled')
            ->select('auctions.*')
            ->join('categories', 'auctions.category_id', '=', 'categories.id')
            ->with(['category', 'auctionImages' => function($query) {
                $query->first();
            }])
            ->groupBy('categories.id')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $carouselItems = $featuredAuctions->map(function($auction) {
            return [
                'title' => $auction->title,
                'description' => $auction->description,
                'buttonAction' => '',
                'imageUrl' => $auction->auctionImages->first()->path ?? '/images/placeholder.jpg'
            ];
        })->toArray();
        */

        // Mock carouselItems data for now
        $carouselItems = [
            [
                'title' => 'Vintage Rolex Submariner',
                'description' => 'Rare 1960s Rolex Submariner in excellent condition. Original parts with documented history.',
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/watch1.jpg'
            ],
            [
                'title' => '1969 Ford Mustang',
                'description' => 'Classic American muscle car, fully restored with original V8 engine.',
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/car1.jpg'
            ],
            [
                'title' => 'Diamond Engagement Ring',
                'description' => '2.5 carat diamond ring with platinum band, certified by GIA.',
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/jewelry1.jpg'
            ],
            [
                'title' => 'First Edition Harry Potter',
                'description' => 'First edition, first printing of Harry Potter and the Philosopher\'s Stone.',
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/book1.jpg'
            ],
        ];

        return view('home.home', compact('categories', 'carouselItems'));
    }

    private function createMockCategory($name)
    {
        $category = new stdClass();
        $category->name = $name;
        return $category;
    }
}
