<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function updateDescription(Request $request)
  {
    $request->validate([
      'description' => 'nullable|string|max:255',  // Adjust validation rules as needed
    ]);

    $user = auth()->user();
    $user->description = $request->input('description');
    $user->save();

    return redirect()->back()->with('success', 'Description updated successfully!');
  }

  public function showProfile($username = null)
  {
    try {
      $user = $username
        ? User::where('username', $username)->firstOrFail()
        : auth()->user();

      $isOwner = auth()->check() && auth()->user()->id === $user->id;

      return view('pages.user.profile', [
        'user' => $user,
        'isOwner' => $isOwner,
      ]);
    } catch (ModelNotFoundException $e) {
      // Handle the exception (e.g., redirect to a 404 page or display an error)
      abort(404, 'User not found.');
    }
  }
}
