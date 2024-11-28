<?php

namespace App\Http\Controllers;

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
    if ($username) {
      // Visiting another user's profile
      $user = User::where('username', $username)->firstOrFail();
      $isOwner = auth()->check() && auth()->user()->id === $user->id;
    } else {
      // Visiting own profile
      $user = auth()->user();
      $isOwner = true;
    }

    return view('pages.user.dashboard', [
      'user' => $user,
      'isOwner' => $isOwner,
    ]);
  }
}
