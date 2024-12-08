@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
  {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
  @foreach ($errors->all() as $error)
  <p>{{ $error }}</p>
  @endforeach
</div>
@endif

<body class="bg-gray-100">

  <!-- Auction Images Section -->
  <div class="auction-images my-12 py-8">
    @php
    $auctionImages = $auction->images;
    @endphp

    @if(!$auctionImages->isEmpty())
    <div class="grid grid-cols-1 gap-6 justify-center items-center"> <!-- Use grid for fixed size and spacing -->
      @foreach ($auctionImages as $auctionImage)
      @if($auctionImage->path)
      @php
      $image = $auction->auctionImage($auctionImage->path);
      @endphp
      <img
        src="{{ $image }}"
        alt="{{ $auction->title }}"
        class="w-[400px] h-[300px] object-cover rounded-lg shadow-md mx-auto"> <!-- Fixed size with space between images -->
      @endif
      @endforeach
    </div>
    @endif
  </div>

  <div class="container mx-auto px-4 py-6">
    <!-- Main Container for Auction Details and Sidebar -->
    <div class="flex flex-col lg:flex-row gap-6">

      <!-- Auction Details (Left Side) -->
      <div class="flex-1 bg-white shadow-md rounded p-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $auction->title }}</h1>
        <p class="text-gray-600 mt-2">{{ $auction->description }}</p>

        <div class="mt-4 text-gray-500 space-y-2">
          <p>Start Price: <span class="font-semibold">${{ number_format($auction->start_price, 2) }}</span></p>
          <p>Current Bid:
            <span class="font-semibold">
              {{ $auction->bids->first() ? '$' . number_format($auction->bids->first()->amount, 2) : 'No bids yet' }}
            </span>
          </p>
          <p>Category: <span class="font-semibold">{{ $auction->categoryName() ?? 'Uncategorized' }}</span></p>
          <p>Start Date:
            <span class="font-semibold">{{ $auction->start_date->format('d M Y, H:i') }}</span>
          </p>
          <p>End Date:
            <span class="font-semibold">
              {{ $auction->end_date ? $auction->end_date->format('d M Y, H:i') : 'No end date specified' }}
            </span>
          </p>
          <p>State: <span class="font-semibold capitalize">{{ $auction->state }}</span></p>
        </div>

        <!-- Auction Remaining Time -->
        <div class="mt-4">
          <p>Remaining Time: <span class="auction-remaining-time font-semibold"></span></p>
          <span class="auction-end-time" hidden>{{ $auction->end_date->format('Y-m-d H:i:s') }}</span>
          <span class="auction-status" hidden>{{ $auction->state }}</span>
        </div>
      </div>

      @auth
      <!-- Sidebar (Right Side) -->
      <div class="w-full lg:w-1/3 space-y-6">
        <!-- User Information Section (Rating + Name) -->
        <div class="bg-white shadow-md rounded p-6">
          <h2 class="text-xl font-semibold text-gray-800">User Information</h2>
          <div class="flex items-center mt-4">
            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center text-white text-2xl">
              <!-- Add user profile image if available -->
              @if($auction->user->profile_image)
              <img src="{{ asset('storage/' . $auction->user->profile_image) }}" alt="{{ $auction->user->name }}" class="w-16 h-16 rounded-full">
              @else
              <img src="{{ asset('/images/defaults/default-profile.jpg') }}" alt="{{ $auction->user->name }}" class="w-16 h-16 rounded-full">
              @endif
            </div>
            <div class="ml-4">
              <p class="font-semibold text-lg">{{ $auction->user->name }}</p>
              <p class="text-gray-600">
                @if($auction->user->rating)
                Rating: <span class="font-semibold">{{ number_format($auction->user->rating, 1) }}</span>
                @else
                Rating: <span class="font-semibold">No rating</span>
                @endif
              </p>
            </div>
          </div>
        </div>

        <!-- Bidding List Section -->
        @if($auction->bids->isNotEmpty())
        <div class="bg-white shadow-md rounded p-6">
          <h2 class="text-xl font-bold text-gray-800 mb-4">Bidding History</h2>
          <div class="space-y-4">
            @foreach($auction->bids as $bid)
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
      </div>



      @endauth
    </div>

    @if(Auth::check() && Auth::id() === $auction->owner_id)

    <a href="{{ route('auction.edit_auction', $auction->id) }}" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
      Edit Auction
    </a>
    @if($auction->state === 'Ongoing')
    <form method="POST" action="{{ route('auction.cancel_auction', $auction->id) }}" class="mt-6">
      @csrf
      <button type="submit"
        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
        Cancel Auction
      </button>
    </form>
    @endif
    <form method="POST" action="{{ route('auction.delete', $auction->id) }}" class="mt-6">
      @csrf
      @method('DELETE')
      <button type="submit"
        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        Delete Auction
      </button>
    </form>
    @else

    <div class="bg-white shadow-md rounded p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-800">Place a Bid</h2>

      <form class="flex flex-col" method="POST" action="{{route('auction.bid', $auction->id) }}">
        @csrf
        <input type="hidden" name="auction_id" value="{{ $auction->id }}">

        <div class="mb-4">
          <label for="amount" class="block text-gray-700 font-semibold mb-2">Your Bid Amount:</label>
          <input
            type="number"
            id="amount"
            name="amount"
            step="0.01"
            min="{{ $auction->bids->max('amount') ? $auction->bids->max('amount') + 1 : $auction->start_price }}"
            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            required>
        </div>

        <button type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Place Bid
        </button>
      </form>
    </div>
    @endif

  </div>

</body>
@endsection
