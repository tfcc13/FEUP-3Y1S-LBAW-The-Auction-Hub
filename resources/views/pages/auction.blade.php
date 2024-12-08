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
        <!-- Auction Images Section -->
        <div class="auction-images my-12 py-8">
            @php
                $auctionImages = $auction->images;
            @endphp

            @if (!$auctionImages->isEmpty())
                <div class="grid grid-cols-1 gap-6 justify-center items-center"> <!-- Use grid for fixed size and spacing -->
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


            @if (Auth::check() && Auth::id() === $auction->owner_id)
                <a href="{{ route('auction.edit_auction', $auction->id) }}"
                    class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Edit Auction
                </a>
                @if ($auction->state === 'Ongoing')
                    <form method="POST" action="{{ route('auction.cancel_auction', $auction->id) }}" class="mt-6">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Cancel Auction
                        </button>
                    </form>
                @endif
                <form method="POST" action="{{ route('auction.delete', $auction->id) }}" class="mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Delete Auction
                    </button>
                </form>
            @endif
        </div>
    </main>
@endsection
