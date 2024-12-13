<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\MoneyManager;
use Illuminate\Support\Facades\DB;
use App\Models\User;

use Illuminate\Http\Request;

class MoneyController extends Controller
{
    public function depositMoney(Request $request, $userId)
    {
        return $this->updateMoney($request, $userId, 'Deposit');
    }

    public function withdrawMoney(Request $request, $userId)
    {
        return $this->updateMoney($request, $userId, 'Withdraw');
    }
    public function updateMoney(Request $request, $userId, $operationType)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'operationType' => 'required|in:Deposit,Withdraw',
        ]);

        $user = User::findOrFail($userId);
        

        if($operationType === 'Withdraw'&& $user->credit_balance < $request->amount){
            return response()->json(['error' => "You don't have sufficient funds"]);
        }

        if($operationType === 'Deposit'&&  $request->amount > 100000){
            return response()->json(['error' => "Deposit amount above limit deposit of 100000$"]);
        }

        try {
            DB::beginTransaction();

            // Create a new transaction record
            $transaction = DB::table('money_manager')->insert([
                'amount' => $request->amount,
                'state' => 'Pending',
                'type' => $request->operationType,
                'user_id' => $user->id,
                'operation_date' => now(),
            ]);

            DB::commit();

            return response()->json(['message' => $operationType . ' request created successfully. Awaiting admin approval.']);
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
