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

    public function addMoney(Request $request)
    {
        // Validate the input
        $request->validate([
            'amount' => 'required|numeric|min:1',  // Ensure the amount is numeric and greater than zero
        ]);

        $user = auth()->user();  // Get the currently logged-in user
        $amount = $request->input('amount');

        try {
            $user->addMoney($amount);
            return response()->json(['message' => 'Money added successfully!', 'balance' => $user->credit_balance], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
