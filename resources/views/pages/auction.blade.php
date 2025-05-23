@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <main class="flex flex-col sm:flex-row bg-gray-100 items-center sm:items-start p-6 min-h-[calc(100vh-5rem)]">
        <div class="flex flex-col w-full sm:w-2/3 text-center space-y-4 ">
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-800">{{ $auction->title }}</h1>
            <p class="text-gray-600 text-base sm:text-xl font-medium">{{ $auction->description }}</p>

            <!-- Auction Images Section -->
            <div class="auction-images py-4">
                @php
                    $auctionImages = $auction->images;
                @endphp

                @if (!empty($auctionImages))
                    <div class="flex flex-col gap-6 justify-center items-center">
                        @foreach ($auctionImages as $index => $auctionImage)
                            @if ($auctionImage->path)
                                @php
                                    $image = $auction->auctionImage($auctionImage->path);
                                @endphp
                                @if ($index % 3 == 0)
                                    <div class="w-full flex justify-center">
                                        <img src="{{ $image }}" alt="Auction item: {{ $auction->title }}"
                                            class="w-[40rem] aspect-[4/3] object-cover rounded-xl select-none"
                                            draggable="false" onload="adjustImageFit(this)" loading="lazy">
                                    </div>
                                @elseif ($index % 3 == 1)
                                    <div class="w-full flex justify-center gap-4">
                                        <img src="{{ $image }}" alt="Auction item: {{ $auction->title }}"
                                            class="w-[30rem] aspect-[4/3] object-cover rounded-xl select-none"
                                            draggable="false" onload="adjustImageFit(this)" loading="lazy">
                                        @if ($index + 1 < count($auctionImages) && $auctionImages[$index + 1] && $auctionImages[$index + 1]->path)
                                            @php
                                                $nextImage = $auction->auctionImage($auctionImages[$index + 1]->path);
                                            @endphp
                                            <img src="{{ $nextImage }}" alt="Auction item: {{ $auction->title }}"
                                                class="w-[30rem] aspect-[4/3] object-cover rounded-xl select-none"
                                                draggable="false" onload="adjustImageFit(this)" loading="lazy">
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Auction Details and Bid Info -->
        <div class="flex flex-col sm:w-1/3 space-y-8">
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

<script>
    function adjustImageFit(img) {
        if (img.naturalHeight > img.naturalWidth) {
            img.style.objectFit = 'scale-down';
        } else {
            img.style.objectFit = 'cover';
        }
    }
</script>
