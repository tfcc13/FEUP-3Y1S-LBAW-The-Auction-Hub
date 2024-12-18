@extends('layouts.user.dashboard')

@section('inner_content')
    <div class="flex flex-col space-y-6 w-full" id="financial-content">
        <h3 class="text-2xl font-semibold text-gray-800">Your Auctions</h3>

        @if ($auctions->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($auctions as $auction)
                    <x-slide.slide-item :title="$auction->title" :currentBid="$auction->current_bid ?? $auction->start_price" :imageUrl="asset($auction->primaryImage())" :buttonAction="route('auctions.show', $auction->id)"
                        :isOwner="true" />
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-600 text-lg">You haven't created any auctions yet.</p>
                <a href="{{ route('auctions.create') }}" class="mt-4 inline-block text-[#135d3b] hover:text-[#135d3b]/85">
                    Create Your First Auction
                </a>
            </div>
        @endif
    </div>
@endsection
