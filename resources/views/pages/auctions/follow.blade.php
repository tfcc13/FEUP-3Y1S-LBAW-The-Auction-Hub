@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Followed Auctions</h1>
        
        @if ($followed->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($followed as $auction)
                    <x-slide.slide-item 
                        :title="$auction->title" 
                        :currentBid="$auction->current_bid ?? $auction->start_price" 
                        :imageUrl="asset($auction->primaryImage())" 
                        :buttonAction="route('auctions.show', $auction->id)" 
                    />
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
