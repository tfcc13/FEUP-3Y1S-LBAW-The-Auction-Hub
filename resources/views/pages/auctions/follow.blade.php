@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center py-6 px-2 space-y-6">
        <h1 class="text-2xl sm:text-4xl sm:font-semibold text-gray-800 text-center whitespace-nowrap">Followed Auctions</h1>

        @if ($followed->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($followed as $auction)
                    <x-slide.slide-item :title="$auction->title" :currentBid="$auction->current_bid ?? $auction->start_price" :imageUrl="asset($auction->primaryImage())" :buttonAction="route('auctions.show', $auction->id)" />
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-600 text-lg">You don't follow any auctions yet.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block text-[#135d3b] hover:text-[#135d3b]/85">
                    Browse auctions to follow
                </a>
            </div>
        @endif
    </div>
@endsection
