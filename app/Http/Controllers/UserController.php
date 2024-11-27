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
}
