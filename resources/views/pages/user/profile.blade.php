@extends('layouts.app')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-1 md:grid-cols-6 lg:grid-cols-8 gap-6">

    <!-- Left Side: Picture and Description -->
    <div class="md:col-start-2 lg:col-start-2 md:col-span-1 lg:col-span-2">

      <!-- Picture Section -->
      <div class="w-full p-4 border border-gray-200 rounded shadow md:p-6 dark:border-gray-700">
        <!-- User Profile Picture -->
        <div class="flex items-center justify-center h-48 mb-4 rounded overflow-hidden">
          <div class="w-48 h-48">
            <x-user.image class="h-full w-full object-fill rounded"></x-user>
          </div>
        </div>

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
        <!-- User's Auctions -->
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h4 class="text-lg font-semibold mb-4">Your Auctions</h4>
          <ul>
            @forelse (auth()->user()->ownAuction as $auction)
            <li class="mb-2 text-gray-700">
              <a href="{{ route('auctions.show', $auction->id) }}" class="text-blue-600 hover:underline">
                {{ $auction->title }}
              </a>
              <span class="ml-2 text-sm text-gray-500">
                ({{ $auction->state }})
              </span>
            </li>
            @empty
            <li class="text-gray-500">You don't own any auctions yet.</li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
