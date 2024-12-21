@extends('layouts.admin.dashboard')

@section('Display')
    <!-- Reports Section -->
    <div class="flex flex-col space-y-6 w-full" id="admin-reports">
        <h3 class="text-2xl font-semibold text-gray-800">Manage Reports</h3>

        <ul class="mt-4 space-y-2">
            @forelse ($reports as $report)
                <li class="flex items-center p-4 border border-gray-200 rounded shadow-sm" style="list-style: none">
                    <p class="flex w-1/5 text-start font-medium text-gray-700">Auction ID: {{ $report->auction_id }}</p>
                    <p class="flex w-2/5 text-start text-sm text-gray-500">{{ $report->description }}</p>
                    <p class="flex w-1/5 text-start text-sm text-gray-400">Status: {{ $report->state }}</p>
                    <p class="flex w-1/5 justify-end text-sm text-gray-400">Viewed: {{ $report->view_status ? 'Yes' : 'No' }}
                    </p>
                </li>
            @empty
                <li class="text-gray-500">You have no reports.</li>
            @endforelse
        </ul>
    </div>
@endsection
