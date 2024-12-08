@extends('layouts.user')

@section('inner_content')
<div class="mt-6">
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h4 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Your Auction Statistics</h4>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Auction Wins</h5>
        <p class="text-xl font-bold text-gray-800">{{ $auctionWonCount }}</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Total Value of Auctions Won</h5>
        <p class="text-xl font-bold text-green-600">${{ number_format($totalAuctionsWonValue, 2) }}</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Max Auction Value Won</h5>
        <p class="text-xl font-bold text-gray-800">${{ number_format($maxAuctionWonValue, 2) }}</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Avg Auction Value Won</h5>
        <p class="text-xl font-bold text-gray-800">${{ number_format($avgAuctionWonValue, 2) }}</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Total Bids Made</h5>
        <p class="text-xl font-bold text-gray-800">{{ $totalBidsMade }}</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Total Amount Spent on Bids</h5>
        <p class="text-xl font-bold text-red-600">${{ number_format($totalAmountSpentOnBids, 2) }}</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Avg Bid Amount</h5>
        <p class="text-xl font-bold text-gray-800">${{ number_format($avgBidAmount, 2) }}</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Bid Success Rate</h5>
        <p class="text-xl font-bold text-blue-600">{{ $bidSuccessRate }}%</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Total Auctions Participated In</h5>
        <p class="text-xl font-bold text-gray-800">{{ $totalAuctionsParticipatedIn }}</p>
      </div>
      <div class="bg-gray-50 rounded-lg p-4 shadow-md col-span-full">
        <h5 class="text-sm font-semibold text-gray-500 uppercase">Most Active Auction Category</h5>
        <p class="text-xl font-bold text-gray-800">
          @if ($mostActiveCategory)
          {{ \App\Models\Category::find($mostActiveCategory)->name }}
          @else
          N/A
          @endif
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
