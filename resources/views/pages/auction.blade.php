@extends('layouts.app')

@section('content')
<body class="bg-gray-100">
    <!-- Auction Images Section -->
    <div class="auction-images">
        @if($auction->images->isNotEmpty())
            <h2>Images:</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($auction->images as $image)
                    <img 
                        src="{{ $image->path ? asset('storage/' . $image->path) : asset('images/defaults/auction-default.png') }}" 
                        alt="{{ $auction->title }} - Image {{ $loop->iteration }}" 
                        class="w-full h-auto lazyload">
                @endforeach
            </div>
        @else
            <p>No images available for this auction.</p>
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
    </div>
</body>
@endsection