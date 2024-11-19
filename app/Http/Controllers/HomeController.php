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
                'imageUrl' => '/images/submariner_4_3.jpg'
            ],
            [
                'title' => '1969 Ford Mustang',
                'description' => 'Classic American muscle car, fully restored with original V8 engine.',
                'buttonAction' => '',
                'imageUrl' => '/images/gt4_5_4.jpg'
            ],
            [
                'title' => 'Diamond Engagement Ring',
                'description' => '2.5 carat diamond ring with platinum band, certified by GIA.',
                'buttonAction' => '',
                'imageUrl' => '/images/gt4_16_9.jpg'
            ],
            [
                'title' => 'First Edition Harry Potter',
                'description' => 'First edition, first printing of Harry Potter and the Philosopher\'s Stone.',
                'buttonAction' => '',
                'imageUrl' => '/images/presidencial_1_1.jpg'
            ],
        ];

        // Database implementation for slideItems (for later):
        /*
        $featuredAuctionIds = $featuredAuctions->pluck('id');
        
        $slideItems = Auction::where('state', '!=', 'canceled')
            ->whereNotIn('id', $featuredAuctionIds)
            ->with(['auctionImages' => function($query) {
                $query->first();
            }])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->map(function($auction) {
                return [
                    'title' => $auction->title,
                    'current_bid' => $auction->current_bid,
                    'buttonAction' => '',
                    'imageUrl' => $auction->auctionImages->first()->path ?? '/images/placeholder.jpg'
                ];
            })->toArray();
        */

        // Mock slideItems data for now
        $slideItems = [
            [
                'title' => 'Vintage Omega Speedmaster',
                'current_bid' => 4500,
                'buttonAction' => '',
                'imageUrl' => '/images/submariner_4_3.jpg'
            ],
            [
                'title' => '2015 Porsche 911 GT3',
                'current_bid' => 125000,
                'buttonAction' => '',
                'imageUrl' => '/images/gt4_4_3.jpg'
            ],
            [
                'title' => '2015 Porsche 911 GT3',
                'current_bid' => 125000,
                'buttonAction' => '',
                'imageUrl' => '/images/gt4_5_4.jpg'
            ],
            [
                'title' => 'Sapphire and Diamond Necklace',
                'current_bid' => 8900,
                'buttonAction' => '',
                'imageUrl' => '/images/gt4_16_9.jpg'
            ],
            [
                'title' => 'Vintage Rolex Submariner',
                'current_bid' => 3200,
                'buttonAction' => '',
                'imageUrl' => '/images/patek_vertical.jpg'
            ],
            [
                'title' => 'Diamond and Ruby Necklace',
                'current_bid' => 12000,
                'buttonAction' => '',
                'imageUrl' => '/images/presidencial_1_1.jpg'
            ],
            [
                'title' => 'Michael Jordan Game-Worn Jersey',
                'current_bid' => 100000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/sports1.jpg'
            ],
            [
                'title' => 'Picasso Original Painting',
                'current_bid' => 500000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/art1.jpg'
            ],
            [
                'title' => 'Antique Chinese Vase',
                'current_bid' => 8000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/antiques1.jpg'
            ],
            [
                'title' => 'Rare Coin Collection',
                'current_bid' => 15000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/coins1.jpg'
            ],
            [
                'title' => 'Limited Edition iPhone',
                'current_bid' => 2000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/electronics1.jpg'
            ],
            [
                'title' => 'Vintage Omega Seamaster',
                'current_bid' => 2800,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/watch4.jpg'
            ],
            [
                'title' => '2018 Lamborghini Huracan',
                'current_bid' => 180000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/car4.jpg'
            ],
            [
                'title' => 'Sapphire and Emerald Ring',
                'current_bid' => 10000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/jewelry4.jpg'
            ],
            [
                'title' => 'Babe Ruth Autographed Baseball',
                'current_bid' => 50000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/sports2.jpg'
            ],
            [
                'title' => 'Warhol Original Print',
                'current_bid' => 300000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/art2.jpg'
            ],
            [
                'title' => 'Antique Victorian Chair',
                'current_bid' => 5000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/antiques2.jpg'
            ],
            [
                'title' => 'Gold Coin Collection',
                'current_bid' => 20000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/coins2.jpg'
            ],
            [
                'title' => 'Limited Edition MacBook',
                'current_bid' => 3000,
                'buttonAction' => '',
                'imageUrl' => '/images/auctions/electronics2.jpg'
            ]
        ];

        return view('home.home', compact('categories', 'carouselItems', 'slideItems'));
    }

    private function createMockCategory($name)
    {
        $category = new stdClass();
        $category->name = $name;
        return $category;
    }
}
