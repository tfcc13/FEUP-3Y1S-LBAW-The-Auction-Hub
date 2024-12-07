@props(['auction', 'owner' => false])

<div class="flex-1 flex-col bg-white shadow-md rounded p-6 space-y-6 max-w-[26rem] min-w-[22rem]">
    <div class="h-2 bg-[#135d3b] rounded-t-md -mt-6 -mx-6 mb-6"></div>

    <!-- Auction Remaining Time -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-xl">Closes in: </span>
        <span class="auction-remaining-time text-gray-800 text-xl font-bold"></span>
        <span class="auction-end-time" hidden>{{ $auction->end_date->format('Y-m-d H:i:s') }}</span>
        <span class="auction-status" hidden>{{ $auction->state }}</span>
    </div>

    <!-- Current Bid -->
    <div class="flex items-baseline justify-between">
        <span class="text-gray-600 text-xl">Current Bid: </span>
        <span class="text-gray-800 text-xl font-bold">
            {{ $auction->bids->first() ? '$ ' . number_format($auction->bids->first()->amount, 2) : 'No bids yet' }}
        </span>
    </div>

    <!-- Bid Form -->
    @if (!$owner)
        <form class="flex flex-col space-y-4" method="POST" action="{{ route('auction.bid', $auction->id) }}">
            @csrf
            <input type="hidden" name="auction_id" value="{{ $auction->id }}">

            <input type="number" id="amount" name="amount" step="0.01"
                min="{{ $auction->bids->max('amount') ? $auction->bids->max('amount') + 1 : $auction->start_price }}"
                class="form-input" required>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Place Bid
            </button>
        </form>
    @endif
</div>
