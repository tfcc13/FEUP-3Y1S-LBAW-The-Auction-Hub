<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
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
}
