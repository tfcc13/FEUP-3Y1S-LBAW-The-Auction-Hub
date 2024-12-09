<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
  //

  public function dashboard()
  {
    $reports = Report::all();
    return view('pages.admin.dashboard.notification', compact('reports'));
  }

  public function dashboardCategorie()
  {
    $categories = Category::all();
    return view('pages.admin.dashboard.categories', compact('categories'));
  }

  public function deleteUser($userId)
  {
    $user = User::find($userId);

    if (!$user) {
      return redirect()->back()->with('error', 'User not found.');
    }

    try {
      DB::beginTransaction();
      $user->delete();

      DB::commit();
      return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    } catch (\Exception $e) {
      dd($e);

      DB::rollBack();
      return redirect()->back()->with('error', 'Failed to delete the user. Please try again.');
    }
  }

  public function banUser($userId)
  {
    $user = User::find($userId);

    if (!$user) {
      return redirect()->back()->with('error', 'User not found.');
    }

    try {
      DB::beginTransaction();
      $user->ownAuction()->delete();  // Assuming the User has created auctions
      $user->ownsBids()->delete();  // Assuming the User has placed bids
      $user->state = 'Banned';
      $user->save();
      DB::commit();

      // dd($user->state);

      return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    } catch (\Exception $e) {
      dd($e);

      DB::rollBack();
      return redirect()->back()->with('error', 'Failed to delete the user. Please try again.');
    }
  }

  public function unbanUser($userId)
  {
    $user = User::find($userId);

    if (!$user) {
      return redirect()->back()->with('error', 'User not found.');
    }

    try {
      DB::beginTransaction();
      $user->state = 'Active';
      $user->save();
      DB::commit();

      // dd($user->state);

      return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    } catch (\Exception $e) {
      dd($e);

      DB::rollBack();
      return redirect()->back()->with('error', 'Failed to delete the user. Please try again.');
    }
  }

  public function promoteUser($userId)
  {
    $user = User::find($userId);

    if (!$user) {
      return redirect()->back()->with('error', 'User not found.');
    }

    try {
      DB::beginTransaction();
      $user->is_admin = true;
      $user->save();
      DB::commit();
      // dd($user->state);

      return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    } catch (\Exception $e) {
      dd($e);

      DB::rollBack();
      return redirect()->back()->with('error', 'Failed to delete the user. Please try again.');
    }
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

      $users = User::search($searchTerm)->get();

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

  public function createCategory(Request $request)
  {
    $text = $request->input('text');
    try {
      $c = Category::create([
        'name' => $text ? $text : 'New Category',
      ]);
      return redirect()->back();
    } catch (\Illuminate\Database\QueryException $e) {
      if ($e->getCode() == '23505') {
        return redirect()->back()->with('error', 'There allready exists a category with this name.');
      }
      // Handle other database errors
      return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
    }
  }

  public function deleteCategory($categoryId)
  {
    $category = Category::find($categoryId);

    if (!$category) {
      return redirect()->back()->with('error', 'Category not found.');
    }

    try {
      DB::beginTransaction();

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
      return redirect()->back()->with('error', 'Failed to delete the Category. Please try again.');
    }
  }
}
