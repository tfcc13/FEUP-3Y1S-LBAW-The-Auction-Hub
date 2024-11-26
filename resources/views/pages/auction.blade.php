@extends('layouts.app')

@section('content')
<body class="bg-gray-100">
    <!-- Auction Images Section -->
    <div class="auction-images">
        @if($auction->images->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($auction->images as $image)
                    <img 
                        src="{{ $image->path ? asset('storage/' . $image->path) : asset('images/defaults/auction-default.png') }}" 
                        alt="{{ $auction->title }} - Image {{ $loop->iteration }}" 
                        class="w-full h-auto lazyload">
                @endforeach
            </div>
        @else
            <img 
            src="{{ asset('/images/defaults/default-auction.jpg') }}" 
            alt="{{ $auction->title }}" 
            class="w-80 h-auto lazyload mx-auto">
        @endif
    </div>
    
    <div class="container mx-auto px-4 py-6">
        <!-- Auction Details -->
        <div class="bg-white shadow-md rounded p-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $auction->title }}</h1>
            <p class="text-gray-600 mt-2">{{ $auction->description }}</p>

            <div class="mt-4 text-gray-500 space-y-2">
                <p>Start Price: <span class="font-semibold">${{ number_format($auction->start_price, 2) }}</span></p>
                <p>Current Bid: 
                    <span class="font-semibold">
                        {{ $auction->current_bid ? '$' . number_format($auction->current_bid, 2) : 'No bids yet' }}
                    </span>
                </p>
                <p>Category: <span class="font-semibold">{{ $auction->categoryName() ?? 'Uncategorized' }}</span></p>
                <p>Owner: <span class="font-semibold">{{ $auction->user->name ?? 'Unknown' }}</span></p>
                <p>Start Date: 
                    <span class="font-semibold">{{ $auction->start_date->format('d M Y, H:i') }}</span>
                </p>
                <p>End Date: 
                    <span class="font-semibold">
                        {{ $auction->end_date ? $auction->end_date->format('d M Y, H:i') : 'No end date specified' }}
                    </span>
                </p>
                <p>State: <span class="font-semibold capitalize">{{ $auction->state }}</span></p>
            </div>

            <!-- Auction Remaining Time -->
            <div class="mt-4">
                <p>Remaining Time: <span class="auction-remaining-time font-semibold"></span></p>
                <span class="auction-end-time" hidden>{{ $auction->end_date->format('Y-m-d H:i:s') }}</span>
                <span class="auction-status" hidden>{{ $auction->state }}</span>
            </div>
        </div>


        <!-- Bidding List Section -->
        @if($auction->bids->isNotEmpty())
        <div class="bg-white shadow-md rounded p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Bidding History</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($auction->bids as $bid)
                    <div class="bg-gray-50 p-4 rounded shadow">
                        <p><strong>Bidder:</strong> {{ $bid->user->name }}</p>
                        <p><strong>Bid Amount:</strong> ${{ number_format($bid->amount, 2) }}</p>
                        <p><strong>Bid Date:</strong> {{ $bid->bid_date->format('d M Y, H:i') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @else
            <p>No bids placed yet.</p>
        @endif
    </div>
</body>
@endsection