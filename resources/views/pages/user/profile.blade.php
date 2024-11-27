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
            @if(auth()->user()->userImage)
            <img src="{{ asset('storage/' . auth()->user()->userImage->path) }}"
              alt="{{ auth()->user()->name }}"
              class="h-full w-full object-cover">
            @else
            <!-- Placeholder using the component -->
            <x-user.image class="h-full w-full object-fill rounded"></x-user>
              @endif
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
        <!-- You can replace this section with dynamic auction content -->
        <div class="bg-white shadow-lg rounded-lg p-6">
          <h4 class="text-lg font-semibold mb-4">Current Auctions</h4>
          <ul>
            <li class="mb-2 text-gray-700">Auction Item 1: <span class="text-green-600">Active</span></li>
            <li class="mb-2 text-gray-700">Auction Item 2: <span class="text-yellow-600">Upcoming</span></li>
            <li class="mb-2 text-gray-700">Auction Item 3: <span class="text-red-600">Closed</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
