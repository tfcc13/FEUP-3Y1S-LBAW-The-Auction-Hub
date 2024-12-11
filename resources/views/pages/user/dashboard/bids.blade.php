@extends('layouts.user.dashboard')

@section('inner_content')
    <div class="flex flex-col space-y-6 w-full" id="bids-content">
        <h3 class="text-2xl font-semibold text-gray-800">Your Bids</h3>
        @if ($bidsMade->isEmpty())
            <div class="alert alert-info text-center">
                <p>No bids found.</p>
            </div>
        @else
            <div class="divide-y divide-gray-200">
                @foreach ($bidsMade as $bid)
                    <div class="bg-white rounded-xl py-2 px-4 hover:bg-[#135d3b]/5 transition-colors duration-300 cursor-pointer"
                        onclick="window.location.href='{{ route('auctions.show', $bid->auction->id) }}'">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                            <div>
                                <strong class="text-gray-600 text-lg font-medium">Bid ID:</strong>
                                <span class="ml-2 text-gray-800 text-lg font-semibold">{{ $bid->id }}</span>
                            </div>
                            <div>
                                <strong class="text-gray-600 text-lg font-medium">Amount:</strong>
                                <span
                                    class="ml-2 text-gray-800 text-lg font-semibold">${{ number_format($bid->amount, 2) }}</span>
                            </div>
                            <div>
                                <strong class="text-gray-600 text-lg font-medium">Auction:</strong>
                                <span class="ml-2 text-gray-800 text-lg font-semibold">{{ $bid->auction->title }}</span>
                            </div>
                            <button
                                onclick="event.stopPropagation(); window.location.href='{{ route('auctions.show', $bid->auction->id) }}'"
                                class="text-[#135d3b] hover:scale-105 transform transition-all duration-300">
                                View Auction
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
