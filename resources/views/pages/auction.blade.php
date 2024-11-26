@extends('layouts.app')

@section('content')
~<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-6">
        <!-- Auction Details -->
        <div class="bg-white shadow-md rounded p-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $auction->title }}</h1>
            <p class="text-gray-600 mt-2">{{ $auction->description }}</p>

            <div class="mt-4 text-gray-500 space-y-2">
                <p>Start Price: <span class="font-semibold">${{ number_format($auction->start_price, 2) }}</span></p>
                <p>Current Bid: <span class="font-semibold">
                    {{ $auction->current_bid ? '$' . number_format($auction->current_bid, 2) : 'No bids yet' }}
                </span></p>
                <p>Category: <span class="font-semibold">{{ $auction->categoryName() }}</span></p>
                <p>Owner: <span class="font-semibold">{{ $auction->user->name ?? 'Unknown' }}</span></p>
                <p>Start Date: <span class="font-semibold">{{ $auction->start_date }}</span></p>
                <p>End Date: <span class="font-semibold">{{ $auction->end_date ?? 'No end date specified' }}</span></p>
                <p>State: <span class="font-semibold capitalize">{{ $auction->state }}</span></p>
            </div>
        </div>
    </div>
</body>
@endsection