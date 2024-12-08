<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getCategories()
    {
        try {
            $categories = Category::all();
            Log::info('Categories fetched successfully: ' . $categories->count());
            return $categories;
        } catch (Exception $e) {
            Log::error('Failed to fetch categories: ' . $e->getMessage());
            return collect([]);
        }
    }
}
