@extends('layouts.app')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-1 md:grid-cols-6 lg:grid-cols-8 gap-6 md:h-full">

    <!-- Left Side: Picture and Description -->
    <div class="md:col-start-2 border border-gray-700 rounded shadow  lg:col-start-2 md:col-span-1 lg:col-span-2 md:h-full">

      <!-- Picture Section -->
      <div class="w-full p-4 md:p-6">
        <!-- User Profile Picture -->
        <div class="flex items-center justify-center h-48 mb-4 rounded overflow-hidden">
          <div class="w-48 h-48">
            <x-user.image class="h-full w-full object-fill rounded"></x-user>
          </div>
        </div>

      </div>
      <div class="lg:m-5">
        <!-- User Name -->
        <div class="text-xl font-bold text-gray-900 mb-2">
          <span class="mr-2">Name:</span>
          {{ auth()->user()->name }}
        </div>

        <!-- Username -->
        <div class="text-sm text-gray-500  mb-2">
          <span class="mr-2">Username:</span>
          {{ '@' . auth()->user()->username }}
        </div>

        <!-- Email -->
        <div class="text-sm text-gray-500 mb-4">
          <span class="mr-2">Email:</span>
          {{ auth()->user()->email }}
        </div>

        <!-- User Rating -->
        <div class="flex items-center text-gray-900 ">
          <span class="mr-2">Rating:</span>
          <div class="bg-green-500 text-white px-2 py-1 rounded-full">
            {{ auth()->user()->rating ?? 'N/A' }}
          </div>
        </div>
      </div>
    </div>

    <!-- Right Side: Content and Auctions Zone -->
    <div class="md:col-span-3 lg:col-span-4 border dark:border-gray-700">
      <!-- Auctions Zone -->
      <div class="mt-6">
        <!-- User's Auctions - Slide Component -->
        <div class="bg-white shadow-lg rounded-lg p-2">
          <h4 class="text-lg font-semibold mb-4">Your Auctions</h4>


          <x-slide.slide width="100%" height="470px">
            @foreach (auth()->user()->ownAuction as $auction)
            <x-slide.slide-item
              :title="$auction->title"
              :currentBid="$auction->current_bid"
              :imageUrl="asset('' . $auction->primaryImage())"
              :buttonAction="route('auctions.show', $auction->id)"
              size="w-[300px]"
              height="h-[200px]" />
            @endforeach
          </x-slide.slide>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
