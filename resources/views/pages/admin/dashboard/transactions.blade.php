@extends('layouts.admin.dashboard')


@section('Display')
@if(session('error'))
<div class="alert alert-danger text-red-500 bg-red-100 border border-red-400 rounded p-4">
  {{ session('error') }}
</div>
@endif
<div class="container mx-auto p-6">
  <h2 class="text-xl font-semibold mb-4">Manage Transactions</h2>
  
  <table class="table-auto w-full bg-white shadow-md rounded">
    <thead>
      <tr>
        <th class="px-4 py-2 border">User</th>
        <th class="px-4 py-2 border">Amount</th>
        <th class="px-4 py-2 border">Date</th>
        <th class="px-4 py-2 border">Type</th>
        <th class="px-4 py-2 border">State</th>
        <th class="px-4 py-2 border">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($transactions as $transaction)
      <tr>
        <td class="px-4 py-2 border">{{ $transaction->user->username }}</td>
        <td class="px-4 py-2 border">${{ number_format($transaction->amount, 2) }}</td>
        <td class="px-4 py-2 border">{{ $transaction->operation_date }}</td>
        <td class="px-4 py-2 border">{{ $transaction->type }}</td>
        <td class="px-4 py-2 border">{{ $transaction->state }}</td>
        <td class="px-4 py-2 border">
            @if($transaction->state === 'Pending')
                <form action="{{ route('admin.transactions.approve', $transaction->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
                </form>
                <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Reject</button>
                </form>
            @else
                <span class="text-gray-500">Nothing to do</span>
            @endif

        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection