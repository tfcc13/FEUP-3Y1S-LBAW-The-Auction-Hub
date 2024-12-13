@extends('layouts.admin.dashboard')

@section('Display')
<!-- Main Content -->
<div class="flex-1 p-8 bg-white">
  <h3 class="text-2xl font-semibold text-[rgb(19,93,59)]">Auction Reports Dashboard</h3>
  <p class="mt-2 text-gray-600">Below are auctions with the highest number of reports.</p>

  <!-- Reports Section -->
  <div class="mt-8">
    <h4 class="text-xl font-semibold text-gray-800">Top Reported Auctions</h4>
    <ul class="mt-4 space-y-2">
      @forelse ($reportsPerAuction as $auction)
      <li class="p-4 border border-gray-200 rounded shadow-sm">
        <p class="font-medium text-gray-700">Auction Title: {{ $auction->title }}</p>
        <p class="text-sm text-gray-500">Reports: {{ $auction->report_count }}</p>
        <p class="text-sm text-gray-500">Owner: {{ $auction->owner_name }} ({{ $auction->owner_username }})</p>
        <a href="{{ route('auctions.show', ['id' => $auction->auction_id]) }}"
          class="inline-block px-4 py-2 mt-2 bg-[rgb(19,93,59)] text-white rounded hover:bg-[rgb(19,93,59)]">
          View
        </a>
      </li>
      @empty
      <li class="text-gray-500">No reported auctions found.</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection
