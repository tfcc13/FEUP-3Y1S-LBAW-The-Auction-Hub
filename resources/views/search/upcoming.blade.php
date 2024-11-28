@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
  <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">Recent Auctions (Started in the Next 7 Days)</h1>

  @if(isset($error))
  <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
    <p class="font-bold">Error</p>
    <p>{{ $error }}</p>
  </div>
  @elseif(isset($message))
  <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded mb-6">
    <p>{{ $message }}</p>
  </div>
  @else
  <p class="mb-6 text-lg text-gray-700">
    Showing auctions that will end in the next 7 days:
  </p>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($auctions as $auction)
    <div class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
      <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-3">{{ $auction->title }}</h2>
        <p class="text-gray-600 mb-4">{{ Str::limit($auction->description, 100) }}</p>
        <p class="text-gray-600 mb-4">Ending on: {{ $auction->end_date->format('F j, Y, g:i a') }}</p>
        <a href="{{ asset('/auctions/auction/' . $auction['id']) }}"
          class="inline-block px-4 py-2 text-white sm:text-base rounded-md bg-[#135d3b] hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          View Auction
        </a>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>
@endsection
