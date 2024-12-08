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
        <div class="auction-images flex flex-col w-2/3 text-center space-y-4">
            <h1 class="text-4xl font-bold text-gray-800">{{ $auction->title }}</h1>
            <p class="text-gray-600 text-xl font-medium">{{ $auction->description }}</p>
            {{-- @if ($auction->images->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($auction->images as $image)
                        <img src="{{ $image->path ? asset('storage/' . $image->path) : asset('images/defaults/auction-default.png') }}"
                            alt="{{ $auction->title }} - Image {{ $loop->iteration }}" class="w-full h-auto lazyload">
                    @endforeach
                </div>
            @else --}}
            <img src="{{ asset('/images/defaults/default-auction.jpg') }}" alt="{{ $auction->title }}"
                class="w-80 h-auto lazyload mx-auto">
            {{--  @endif --}}
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

                <!-- Bidding List Section -->
                @if ($auction->bids->isNotEmpty())
                    <div class="bg-white shadow-md rounded p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Bidding History</h2>
                        <div class="space-y-4">
                            @foreach ($auction->bids as $bid)
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
