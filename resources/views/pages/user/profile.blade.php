@extends('layouts.app')

@section('content')
<div class="p-4">
  <div class="grid grid-cols-1 md:grid-cols-6 lg:grid-cols-8 gap-6 md:h-full">

    <!-- Left Side: Picture and Description -->
    <div class="md:col-start-2 border border-gray-700 rounded shadow  lg:col-start-2 md:col-span-2 lg:col-span-2 md:h-full">

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
        <div class="text-md font-bold text-gray-900 mb-2 sm:text-lg md:text-xl">
          <span class="mr-2">Name:</span>
          <span class="break-words">{{ auth()->user()->name }}</span>
        </div>

        <!-- Username -->
        <div class="text-md text-gray-500 font-bold mb-2 sm:text-lg md:text-xl">
          <span class="mr-2">Username:</span>
          <span class="break-words">{{ auth()->user()->username }}</span>
        </div>

        <!-- Email -->
        <div class="text-md text-gray-500 mb-4 sm:text-lg md:text-xl">
          <span class="mr-2 font-bold">Email:</span>
          <span class="break-words">{{ auth()->user()->email }}</span>
        </div>

        <!-- User Rating -->
        <div class="flex items-center text-gray-900 mb-4 sm:text-lg md:text-xl">
          <span class="mr-2 font-bold">Rating:</span>

          <div class="flex items-center">
            <!-- Rating stars or content goes here -->
            @php
            $rating = auth()->user()->rating ?? 0;
            $fullStars = floor($rating);
            $hasHalfStar = $rating - $fullStars >= 0.5;
            $emptyStars = 5 - ceil($rating);
            @endphp

            <!-- Full stars -->
            @for ($i = 0; $i < $fullStars; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24" stroke="none">
              <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
              </svg>
              @endfor

              <!-- Half star -->
              @if ($hasHalfStar)
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
              </svg>
              @endif

              <!-- Empty stars -->
              @for ($i = 0; $i < $emptyStars; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                @endfor
          </div>
        </div>
        <div>
          <span class="text-md">
            Description:
          </span>
          <p>{{ auth()->user()->description ?? 'No description set' }}</p> <!-- Display default text if no description -->

          <!-- Button to trigger the edit modal or form -->
          <button
            class="px-3 py-2 rounded-md border border-gray-300 bg-[#135d3b] focus:ring-2 focus:ring-gray-300"
            data-modal-toggle="edit-description-modal">
            Change Description
          </button>

          <!-- Modal to change description -->
          <div id="edit-description-modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white rounded-lg p-6 shadow-lg max-w-lg w-full">
              <h2 class="text-xl font-semibold text-gray-900 mb-4">Edit Description</h2>

              <!-- Form to update description -->
              <form action="{{ route('user.updateDescription') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                  <textarea name="description" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4">{{ auth()->user()->description ?? '' }}</textarea>
                </div>

                <div class="flex justify-end space-x-4">
                  <button type="submit" class=" px-6 py-2 rounded-md border border-gray-300 bg-[#135d3b] focus:ring-2 focus:ring-gray-300">
                    Save Changes
                  </button>
                  <button
                    type="button"
                    class=" px-6 py-2 rounded-md border border-gray-300 bg-[#135d3b] focus:ring-2 focus:ring-gray-300"
                    onclick="document.getElementById('edit-description-modal').classList.add('hidden')">
                    Cancel
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <script>
          // Toggle modal visibility
          document.querySelector('[data-modal-toggle="edit-description-modal"]').addEventListener('click', function() {
            document.getElementById('edit-description-modal').classList.toggle('hidden');
          });
        </script>
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
