@extends('layouts.app')

@section('content')

<!-- Header Section -->
<div class="flex flex-col sm:flex-row items-center justify-center w-full space-x-0 sm:space-x-6 space-y-2 sm:space-y-0">
  <h1 class="text-2xl sm:text-4xl sm:font-semibold text-gray-800 text-center whitespace-nowrap">Category {{$name}}</h1>
</div>

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

  @if (isset($error))
  <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
    <p class="font-bold">Error</p>
    <p>{{ $error }}</p>
  </div>
  @elseif(isset($message))
  <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded mb-6">
    <p>{{ $message }}</p>
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
