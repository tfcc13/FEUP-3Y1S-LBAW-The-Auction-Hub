<?php

namespace App\Http\Controllers;

// We'll need this later when we implement the database
// use App\Models\Category;

use Illuminate\Database\Eloquent\Collection;
use stdClass;

class HomeController extends Controller
{
    public function index()
    {
        // Database implementation for later:
        // $categories = Category::all();

        // Mock categories data for now
        $categories = collect([
            $this->createMockCategory('Watches'),
            $this->createMockCategory('Vehicles'),
            $this->createMockCategory('Jewelry'),
            $this->createMockCategory('Collectibles'),
            $this->createMockCategory('Sports Memorabilia'),
            $this->createMockCategory('Art'),
            $this->createMockCategory('Antiques'),
            $this->createMockCategory('Coins & Paper Money'),
            $this->createMockCategory('Electronics'),
        ]);

        return view('home.home', compact('categories'));
    }

    private function createMockCategory($name)
    {
        $category = new stdClass();
        $category->name = $name;
        return $category;
    }
}
