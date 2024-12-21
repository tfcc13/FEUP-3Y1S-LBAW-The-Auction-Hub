@extends('layouts.admin.dashboard')


@section('Display')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-red-500 bg-red-100 border border-red-400 rounded p-4">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex flex-col space-y-6 w-full" id="admin-transactions">
        <h3 class="text-2xl font-semibold text-gray-800">Manage Transactions</h3>

        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">User</th>
                    <th class="px-4 py-2 border">Reference</th>
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
                        <td class="px-4 py-2 border">{{ $transaction->reference ?? '-' }}</td>
                        <td class="px-4 py-2 border">${{ number_format($transaction->amount, 2) }}</td>
                        <td class="px-4 py-2 border">{{ $transaction->operation_date }}</td>
                        <td class="px-4 py-2 border">{{ $transaction->type }}</td>
                        <td class="px-4 py-2 border">{{ $transaction->state }}</td>
                        <td class="px-4 py-2 border">
                            @if ($transaction->state === 'Pending')
                                <form action="{{ route('admin.transactions.approve', $transaction->id) }}" method="POST"
                                    class="inline-block approve-form">
                                    @csrf
                                    @method('PATCH')
                                    @if ($transaction->user->username !== $transaction->reference && $transaction->type === 'Deposit')
                                        <x-toast.confirm :buttonText="'Approve'" :route="'admin.transactions.approve'" :method="'PATCH'"
                                            :id="'transaction-approve' . $transaction->id" :modalTitle="'Approve ' . $transaction->type . '?'" :modalMessage="'Reference doesnt match are you sure you want to approve this transaction?'" :object="$transaction" />
                                    @else
                                        <button type="submit"
                                            class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
                                    @endif
                                </form>
                                <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST"
                                    class="inline-block">
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.approve-form').forEach(form => {
            const modalButton = form.querySelector('[data-modal-target]');
            if (!modalButton) return;

            const modalId = modalButton.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            const confirmButton = modal.querySelector('button[type="submit"]');
            const cancelButton = modal.querySelector('.cancelButton');

            form.addEventListener('submit', (e) => {
                e.preventDefault();
            });

            modalButton.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.remove('hidden');
            });

            cancelButton.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.add('hidden');
            });

            confirmButton.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.add('hidden');
                form.submit();
            });
        });
    });
</script>
