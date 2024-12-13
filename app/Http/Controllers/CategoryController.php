<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
  /** Show a Category Page */

  /**
   * Create a new category.
   */
  public function store(Request $request)
  {
    $text = $request->input('text');

    try {
      $category = Category::create([
        'name' => $text ? $text : 'New Category',
      ]);

      return redirect()->back()->with('success', 'Category created successfully.');
    } catch (\Illuminate\Database\QueryException $e) {
      if ($e->getCode() == '23505') {  // Unique constraint violation
        return redirect()->back()->with('error', 'A category with this name already exists.');
      }

      // Handle other database errors
      return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
    }
  }

  /**
   * Delete an existing category.
   */
  public function destroy($categoryId)
  {
    $category = Category::find($categoryId);

    if (!$category) {
      return redirect()->back()->with('error', 'Category not found.');
    }

    try {
      DB::beginTransaction();

      // Check if the category has associated auctions
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
      return redirect()->back()->with('error', 'Failed to delete the category. Please try again.');
    }
  }
}
