@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <main class="flex flex-col sm:flex-row bg-gray-100 items-start p-6">
        <div class="flex flex-col w-2/3 text-center space-y-4">
            <h1 class="text-4xl font-bold text-gray-800">{{ $auction->title }}</h1>
            <p class="text-gray-600 text-xl font-medium">{{ $auction->description }}</p>

            <!-- Auction Images Section -->
            <div class="auction-images my-12 py-8">
                @php
                    $auctionImages = $auction->images;
                @endphp

                @if (!$auctionImages->isEmpty())
                    <div class="grid grid-cols-1 gap-6 justify-center items-center">
                        <!-- Use grid for fixed size and spacing -->
                        @foreach ($auctionImages as $auctionImage)
                            @if ($auctionImage->path)
                                @php
                                    $image = $auction->auctionImage($auctionImage->path);
                                @endphp
                                <img src="{{ $image }}" alt="{{ $auction->title }}"
                                    class="w-[400px] h-[300px] object-cover rounded-lg shadow-md mx-auto">
                                <!-- Fixed size with space between images -->
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Auction Details and Bid Info -->
        <div class="flex flex-col w-1/3 space-y-8">
            <!-- Auction Details (Left Side) -->
            <x-auction.bid_card :auction="$auction" :owner="Auth::check() && Auth::id() === $auction->owner_id" />

            <!-- Auction Info -->
            <x-auction.info_card :auction="$auction" />

            @auth
                <!-- Owner Information -->
                <x-auction.owner_info :auction="$auction" />

                <!-- Bidding History -->
                <x-auction.bidding_history :auction="$auction" />
            @endauth
        </div>
    </main>
@endsection
