@extends('layouts.app')

@section('content')
    <script>
        window.addEventListener('load', function() {
            const upcomingCategory = document.getElementById('upcoming-category');
            if (upcomingCategory) {
                const button = upcomingCategory.querySelector('button');
                if (button) {
                    button.focus();
                }
            }
        });
    </script>

    <main class="flex flex-col items-center py-4 px-6 space-y-8">
        <!-- Categories section -->
        <x-categories.categories :categories="$categories" />

        <div class="flex flex-col space-y-4">
            <!-- Upcoming Auctions Title -->
            <h1 class="text-2xl sm:text-4xl sm:font-semibold text-gray-800 text-center whitespace-nowrap">Upcoming Auctions
            </h1>

            <!-- Upcoming Auctions Description -->
            <p class="text-base text-gray-400 text-center">
                These auctions will end in the next 7 days
            </p>
        </div>

        <!-- Error or Message Section -->
        @if (isset($error) || isset($message))
            <div class="absolute top-[40%] flex flex-col items-center text-gray-800 text-2xl space-y-4 error-message">
                <span class="material-symbols-outlined" style="font-size: 9rem; font-weight: 200;">search_off</span>
                <p>{{ $error ?? $message }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($auctions as $auction)
                    <x-slide.slide-item :title="$auction->title" :currentBid="$auction->bids->first() ? $auction->bids->first()->amount : $auction->start_price" :imageUrl="$auction->primaryImage" :buttonAction="asset('/auctions/auction/' . $auction->id)"
                        :endDate="$auction->end_date->format('M d, h:i A')" :searchResults="true" />
                @endforeach
            </div>
        @endif
    </main>
@endsection
