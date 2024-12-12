<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\MoneyManager;
use Illuminate\Support\Facades\DB;
use App\Models\User;

use Illuminate\Http\Request;

class MoneyController extends Controller
{

    public function addMoney(Request $request, $userId)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        $user = User::findOrFail($userId);

        try {
            DB::beginTransaction();

            // Create a new transaction record
            $transaction = DB::table('money_manager')->insert([
                'amount' => $request->amount,
                'state' => 'Pending',
                'type' => 'Deposit',
                'user_id' => $user->id,
                'operation_date' => now(),
            ]);

            DB::commit();

            return response()->json(['message' => 'Deposit request created successfully. Awaiting admin approval.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function approveTransaction(Request $request, $transactionId)
    {
        $transaction = MoneyManager::findOrFail($transactionId);

        if($transaction->state !== 'Pending') {
            return redirect()->back()->with('error', 'Cannot alter the state of a completed transaction');
        }

        try {
            DB::beginTransaction();

            $transaction->state = 'Approved';
            $transaction->save();

            $user = $transaction->user; 
            $user->credit_balance += $transaction->amount;
            $user->save();
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Transaction approved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function rejectTransaction(Request $request, $transactionId)
    {
        $transaction = MoneyManager::findOrFail($transactionId);
        if($transaction->state !== 'Pending') {
            return redirect()->back()->with('error', 'Cannot alter the state of a completed transaction');
        }
        try {
            DB::beginTransaction();

            $transaction->state = 'Denied';
            $transaction->save();

            DB::commit();

            return redirect()->back()->with('success', 'Transaction rejected successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


}
